<?php
use Phalcon\Mvc\Model;

class Event extends Model{

	public function getSource(){
    return "events"; // ชื่อ ตาราง ใน ฐานข้อมูล จริงๆ
  }
}