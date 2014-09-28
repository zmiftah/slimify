<?php

namespace App\Controller;

use App\Lib\Controller;
use App\Lib\Paginator;
use App\Model\Event;
use App\Model\EventDisposisi;

class SampleController extends Controller
{
    public function timeline($page=1)
    {
        if (!$this->getApp()->auth->verifyACL('view_timeline')) $this->noAkses();

        // Filter Date
        $date = (new \DateTime())->format('Y-m-d');

        // Get Data
        $count = Event::where_gte('tanggal_awal', $date)->count();
        $offset = ($page - 1) * $this->per_page;
        $events = Event::where_gte('tanggal_awal', $date)
        ->limit($this->per_page)
        ->offset($offset)
        ->find_many();

        // Build Pager
        $pages = new Paginator( $count, $this->per_page, BASE_URL.'/timeline/page/' );
        $pages->setPage($page);
        $pager = $pages->showPager();

        $this->renderTpl('event_timeline', [
            'date'=>$date,
            'events'=>$events,
            'pager'=>$pager,
            'count'=>$count,
            'offset'=>$offset
        ]);
    }
    public function listEvent($page=1) 
    {
        // Check ACL
        if (!$this->getApp()->auth->verifyACL('view_event')) $this->noAkses();

        // Alert
        $alert      = $this->getApp()->session->flashGet( 'event_alert' );
        $alert_type = $this->getApp()->session->flashGet( 'event_alert_type' );
        
        // Get Data
        $count = Event::count();
        $offset = ($page - 1) * $this->per_page;
        $events = Event::limit($this->per_page)->offset($offset)->find_many();

        // Build Pager
        $pages = new Paginator( $count, $this->per_page, BASE_URL.'/jadwal/page/' );
        $pages->setPage($page);
        $pager = $pages->showPager();

        $this->renderTpl('event_list', [
            'events'=>$events,
            'pager'=>$pager,
            'count'=>$count,
            'offset'=>$offset,
            'alert'=>$alert,
            'alert_type'=>$alert_type,
        ]);
    }
    public function addEvent() 
    {
        if (!$this->getApp()->auth->verifyACL('add_event')) $this->noAkses();

        if (isset($_POST['mode'])) {
            $event = Event::create();

            if ($this->action($event, 'Tambah')) {
                $message = "Event dengan no surat '$event->no_surat' berhasil ditambahkan.";
                $this->getApp()->session->flashSet('event_alert', $message);

                $this->redirectUrl('jadwal');
            } else {
                $message = "Penyimpanan Jadwal gagal atau Jadwal sudah ada!";
            }
        }

        $this->renderTpl('event_form', [
            'mode'=>'Tambah',
            'message'=>$message
        ]);
    }
    public function editEvent($id) 
    {
        if (!$this->getApp()->auth->verifyACL('edit_event')) $this->noAkses();

        $event = Event::find_one($id);

        if (!$event instanceof Event) {
            // Return to list
        }

        if (isset($_POST['mode'])) {
            if ($this->action($event, 'Tambah')) {
                $message = "Event dengan no  surat '$event->no_surat' berhasil diupdate.";
                $this->getApp()->session->flashSet('event_alert', $message);

                $this->redirectUrl('jadwal');
            } else {
                $message = "Penyimpanan Jadwal gagal!";
            }
        }

        $tanggal = $event->tanggal_awal.' - '.$event->tanggal_akhir;

        $this->renderTpl('event_form', [
            'mode'=>'Edit',
            'event'=>$event,
            'tanggal'=>$tanggal
        ]);
    }
    public function deleteEvent($id) 
    {
        if (!$this->getApp()->auth->verifyACL('delete_event')) $this->noAkses();

        $event = Event::find_one($id);
        if( $event instanceof Event ) {
            $noSurat = $event->no_surat;
            $event->delete();

            $this->getApp()->session->flashSet( 'event_alert', "Event dengan no surat '$noSurat' berhasil dihapus." );
        } else {
            $this->getApp()->session->flashSet( 'event_alert', "Event ID: $id tidak ditemukan." );
            $this->getApp()->session->flashSet( 'event_alert_type', 'error' );
        };

        $this->redirectUrl( 'jadwal' );
    }
    public function ajaxDisposisi()
    {
        header('Content-Type: application/json');

        switch ($_POST['mode']) {
            case 'Hapus':
                $disposisi = EventDisposisi::find_one($_POST['id']);
                $result = $disposisi->delete();
                if ($result) {
                    $message = "Berhasil menghapus '{$_POST[name]}'";
                } else {
                    $message = "Gagal menghapus '{$_POST[name]}'";
                }
                break;
            case 'Tambah':
            default:
                $disposisi = EventDisposisi::create();
                $disposisi->event_id = $_POST['event_id'];
                $disposisi->name = $_POST['name'];
                $disposisi->email = $_POST['email'];
                $disposisi->remindme = $_POST['ingat'];
                $result = $disposisi->save();
                if ($result) {
                    $message = "Berhasil menambahkan '{$_POST[name]}'";
                } else {
                    $message = "Gagal menambahkan '{$_POST[name]}'";
                }
                break;
        }

        echo json_encode(['result'=>$result, 'message'=>$message]);
    }

    protected function action($event, $mode)
    {
        // Sanitize
        list($tgl_awal, $tgl_akhir) = explode(' - ', $_POST['tanggal']);
        
        $event->no_surat        = $_POST['no_surat'];
        $event->asal_surat      = $_POST['asal_surat'];
        $event->tanggal_awal    = $tgl_awal;
        $event->tanggal_akhir   = $tgl_akhir;
        $event->waktu           = $_POST['waktu'];
        $event->tempat          = $_POST['tempat'];
        $event->kegiatan        = $_POST['kegiatan'];

        if ($mode == 'Tambah') {
            $event->insert_by       = $this->getApp()->auth->getUserId();
            $event->insert_datetime = date('Y-m-d H:i:s');
        } else {
            $event->last_update_by = $this->getApp()->auth->getUserId();
            $event->last_update_datetime = date('Y-m-d H:i:s');
        }

        return $event->save();
    }
}
