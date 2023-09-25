<?php
// class horloge qui herite de la classe crud 
class Horloge extends Crud {
    public $id;
    public $brand;
    public $type;
    public $model;
    public $price;

    
    public function ajouterHorloge($horloge) {
        return parent::ajouterHorloge($horloge);
    }

    public function updateHorloge() {
        $horlogeData = [
            'brand' => $this->brand,
            'type' => $this->type,
            'model' => $this->model,
            'price' => $this->price
        ];
        parent::updateHorlogeById($this->id, $horlogeData);
    }

    public function deleteHorloge() {
        return parent::deleteHorlogeById($this->id);
    }
}
