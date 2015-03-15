<?PHP

class DB {
	public $host;
	public $db;
	public $user;
	public $password;

	function __construct(){
		$this->host='localhost';
		$this->db = 'LittleSister';
		$this->user = 'user';
		$this->password = 'password';
	}
}