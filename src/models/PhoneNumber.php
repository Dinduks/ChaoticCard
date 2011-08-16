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
        if (!$this->getId())
            throw new Exception("You cannot load an empty object!");
        
        $query = "SELECT * FROM phonenumber WHERE id = ?";
        $phoneNumber = $this->app["db"]->fetchAssoc($query, array($this->getId()));
        $this->setPhoneNumber($phoneNumber["phonenumber"]);
    }
    
    function save() {
        if (!$this->getId())
            throw new Exception("You cannot save an empty object!");
        
        $query = "INSERT INTO phonenumber (id, phonenumber) VALUES (NULL, ".$this->getPhoneNumber().")";
        $this->app["db"]->insert("phonenumber", array(
            "id" => $this->getId(),
            "phonenumber" => $this->getPhoneNumber()
        ));
    }
    
    function update() {
        if (!$this->getId())
            throw new Exception("You cannot update an empty object!");
        
        $this->app["db"]->update("phonenumber", 
                array("phonenumber"=>$this->getPhoneNumber()), 
                array("id"=>$this->getId()));
    }
    
    function delete() {
        if (!$this->getId())
            throw new Exception("You cannot delete an empty object!");
        
        $query = "DELETE FROM phonenumber WHERE id=" . $this->getId();
        $this->app["db"]->delete("phonenumber", array("id"=>$this->getId()));
    }
    
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getPhoneNumber() { return $this->phoneNumber; }
    public function setPhoneNumber($phoneNumber) { $this->phoneNumber = $phoneNumber; }
}
?>
