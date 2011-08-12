<?php
class PhoneNumber {
    private $id;
    private $phoneNumber;
    
    function __construct($app, $id = -1) {
        $this->app = $app;
        if ($id > 0) {
            $this->setId($id);
            $this->load();
        }
    }
    
    function load() {
        $query = "SELECT * FROM phonenumber WHERE id = ?";
        $phoneNumber = $this->app["db"]->fetchAssoc($query, array($id));
        $this->setPhoneNumber($phoneNumber["phonenumber"]);
    }
    
    function save() {
        $query = "INSERT INTO phonenumber (id, phonenumber) VALUES (NULL, ".$this->getPhoneNumber().")";
        $this->app["db"]->insert("phonenumber", array(
            "id" => $this->getId(),
            "phonenumber" => $this->getPhoneNumber()
        ));
    }
    
    function update() {
        $this->app["db"]->update("phonenumber", array("id"=>$this->getId()), array("phonenumber"=>$this->getPhoneNumber()));
    }
    
    function delete() {
        $query = "DELETE FROM phonenumber WHERE id=" . $this->getId();
        $this->app["db"]->delete("phonenumber", array("id"=>$this->getId()));
    }
    
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getPhoneNumber() { return $this->phoneNumber; }
    public function setPhoneNumber($phoneNumber) { $this->phoneNumber = $phoneNumber; }
}
?>
