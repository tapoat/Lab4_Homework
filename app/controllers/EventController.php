<?php

class EventController extends ControllerBase
{

    public function beforeExecuteRoute()
    { // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
        $this->checkAuthen();
    }

    public function indexAction()
    {
        $events = Event::find();
        $this->view->events = $events;

    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $photoUpdate = '';
            if ($this->request->hasFiles(true) == true) {
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $uploads = $this->request->getUploadedFiles();

                $isUploaded = false;
                foreach ($uploads as $upload) {
                    if (in_array($upload->gettype(), $allowed)) {
                        $photoName = md5(uniqid(rand(), true)) . strtolower($upload->getname());
                        $path = '../public/img/' . $photoName;
                        ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
                    }
                }
                if ($isUploaded) {
                    $photoUpdate = $photoName;
                }   
            }

            $name = trim($this->request->getPost('name')); // รับค่าจาก form
            $date = trim($this->request->getPost('date')); // รับค่าจาก form
            $detail = trim($this->request->getPost('detail')); // รับค่าจาก form

            $event = new Event();
            $event->name = $name;
            $event->date = $date;
            $event->detail = $detail;
            $event->picture = $photoUpdate;
            $event->save();
            $this->response->redirect('event');

        }
    }

    public function editAction($id)
    {
        if ($this->request->isPost()) {

            $photoUpdate = '';
            if ($this->request->hasFiles(true) == true) {
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $uploads = $this->request->getUploadedFiles();

                $isUploaded = false;
                foreach ($uploads as $upload) {
                    if (in_array($upload->gettype(), $allowed)) {
                        $photoName = md5(uniqid(rand(), true)) . strtolower($upload->getname());
                        $path = '../public/img/' . $photoName;
                        ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
                    }
                }
                if ($isUploaded) {
                    $photoUpdate = $photoName;
                }   
            }

            $name = trim($this->request->getPost('name')); // รับค่าจาก form
            $date = trim($this->request->getPost('date')); // รับค่าจาก form
            $detail = trim($this->request->getPost('detail')); // รับค่าจาก form

            $event = Event::findFirst($id);
            $event->name = $name;
            $event->date = $date;
            $event->detail = $detail;
            $event->picture = $photoUpdate;
            $event->save();
            $this->response->redirect('event');
		}
        $event = Event::findFirst($id);
        $this->view->event = $event;
    }

    public function deleteAction($id)
    {
        $toDeleteEvent = Event::findFirst($this->request->getPost('id'));
        $toDeleteEvent->delete();
        $this->response->redirect('event');
    }
}
