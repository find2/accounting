<?php
 
// require __DIR__ . '/db_connection.php';
require  '../db_connection.php';
 
class COA
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
	 
    public function Create($code, $name, $type, $balance, $month, $year, $ledger)
    {
        $query = $this->db->prepare("INSERT INTO coa(code, name,  type, balance, month, year, ledger) VALUES (:code, :name, :type, :balance, :month, :year, :ledger)");
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("type", $type, PDO::PARAM_STR);
		$query->bindParam("balance", $balance, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT * FROM coa WHERE month=:month AND year=:year AND ledger=:ledger ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function Delete($id)
    {
        $query = $this->db->prepare("DELETE FROM coa WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
	
	public function Delete_month($month, $year, $ledger)
    {
        $query = $this->db->prepare("DELETE FROM coa WHERE month = :month AND year= :year AND ledger= :ledger");
        $query->bindParam("month", $month, PDO::PARAM_STR);
        $query->bindParam("year", $year, PDO::PARAM_STR);
        $query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
    public function Update($code, $name, $type, $balance, $id)
    {
        $query = $this->db->prepare("UPDATE coa SET code = :code, name=:name, type= :type, balance= :balance WHERE id = :id");
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("type", $type, PDO::PARAM_STR);
		$query->bindParam("balance", $balance, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($id)
    {
        $query = $this->db->prepare("SELECT * FROM coa WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year){
		$data='<h3>Chart of Account '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Account Type</th>
				<th>Account Balance</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Account Type</th>
				<th>Account Balance</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody id="table_data">
		';
		return $data;
	}
	public function show_data($number, $code, $name, $type, $balance, $id){
		$data='
		<tr id="tr_'. $id .'">
			<td>' . $number . '</td>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . $type . '</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
	public function result($number, $status, $debet, $credit, $defisit){
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-right">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="debet">Debet:</label>
							<input type="text" id="debet" placeholder="" class="form-control" disabled/ value="'. number_format($debet,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="credit">Credit:</label>
							<input type="text" id="credit" placeholder="" class="form-control" disabled/ value="'. number_format($credit,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="status">Status:</label>
							<input type="text" id="status" placeholder="" class="form-control" disabled value="'. $status .'"/>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="difference">Difference:</label>
							<input type="text" id="difference" placeholder="" class="form-control" disabled value="'. number_format($defisit,2,",",".") .'"/>
						</div>
					</div>
				</div>
			</div>
			';
		return $data;
	}
}

class Cash
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	public function Get_Ledger($name){
		if($name=='1')
			return "Operational MAA";
		else if($name=='2')
			return "Monarch Shop";
		else if($name=='3')
			return "Yayasan Lisensi";
		else if($name=='4')
			return "LSP LPK Monarch Bali";
		else if($name=='5')
			return "LSP PNI";
		else if($name=='6')
			return "Politeknik Monarch Bali";
		else if($name=='7')
			return "Book Name 7";
	}

    public function Create($date, $kwit, $item, $code, $debet, $credit, $month, $year, $time, $username, $ledger)
    {
        $query = $this->db->prepare("INSERT INTO cash(date, kwit, item, code, debet, credit, month, year, time, created, ledger) VALUES (:date, :kwit, :item, :code, :debet, :credit, :month, :year, :time, :username, :ledger)");
        $query->bindParam("date", $date, PDO::PARAM_STR);
        $query->bindParam("kwit", $kwit, PDO::PARAM_STR);
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read($month, $year, $filter, $m, $ledger)
    {	
		if($filter==2)
			$query = $this->db->prepare("SELECT * FROM cash WHERE month=:month AND year=:year AND ledger= :ledger AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		else
			$query = $this->db->prepare("SELECT * FROM cash WHERE month=:month AND year=:year AND ledger= :ledger ORDER BY date ASC, id ASC");
			
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	
	public function Read_Name($month, $year, $code, $ledger)
    {
        $query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
	}
	

	
	public function Read_Code($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Select_Type($code, $month, $year)
    {
        $query = $this->db->prepare("SELECT type FROM coa WHERE month=:month AND year=:year AND code= :code");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
		}
		foreach($data as $dat){
			$data = $dat['type'];
		}
        return $data;
    }

	public function Read_Cash($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT balance FROM coa WHERE month=:month AND year=:year AND code < '10200' AND ledger=:ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		
        return $data;
    }
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function Delete($user_id)
    {
        $query = $this->db->prepare("DELETE FROM cash WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
    public function Update($date, $kwit, $item, $code, $debet, $credit, $time, $username, $id)
    {
        $query = $this->db->prepare("UPDATE cash SET date= :date, kwit= :kwit, item= :item, code= :code, debet= :debet, credit= :credit,  time= :time, created= :username WHERE id = :id");
        $query->bindParam("date", $date, PDO::PARAM_STR);
        $query->bindParam("kwit", $kwit, PDO::PARAM_STR);
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
		$query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM cash WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year){
		$data='<h3>Cash '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Date Transaction</th>
				<th>No. Kwitansi</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Saldo</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Date Transaction</th>
				<th>No. Kwitansi</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Saldo</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}
	public function show_data($number, $date, $kwit, $item, $code, $name, $debet, $credit, $saldo, $id){
		
		$data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $date . '</td>
			<td>' . $kwit . '</td>
			<td>' . $item . '</td>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . number_format($debet,2,",",".") . '</td>
			<td>' . number_format($credit,2,",",".") . '</td>
			<td>' . number_format($saldo,2,",",".") . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
	
	public function cash_data($balance){
		
		$data='
		<tr>
			<td>' . 1 . '</td>
			<td></td>
			<td></td>
			<td>Opening Balance</td>
			<td>10011</td>
			<td>Cash On Hands</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td>' . number_format(0,2,",",".") . '</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td>
				<button  class="btn btn-xs btn-warning buttton-update" disabled>Update</button>
			</td>
			<td>
				<button class="btn btn-xs btn-danger" disabled>Delete</button>
			</td>
		</tr>';
		return $data;
	}
	
	public function result($debet, $credit, $saldo){
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-right">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="debet">Total Debet:</label>
							<input type="text" id="debet" placeholder="" class="form-control" disabled/ value="'. number_format($debet,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="credit">Total Credit:</label>
							<input type="text" id="credit" placeholder="" class="form-control" disabled/ value="'. number_format($credit,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="difference">Total Saldo:</label>
							<input type="text" id="difference" placeholder="" class="form-control" disabled value="'. number_format($saldo,2,",",".") .'"/>
						</div>
					</div>
				</div>
			</div>
			';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}

class Bank
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
    public function Create($date, $trx, $item, $code, $debet, $credit, $month, $year, $time, $remark, $bank_name, $username, $ledger)
    {
        $query = $this->db->prepare("INSERT INTO bank(date, trx, item, code, debet, credit, month, year, time, remark, bank_name, created, ledger) VALUES (:date, :trx, :item, :code, :debet, :credit, :month, :year, :time, :remark, :bank_name, :username, :ledger)");
        $query->bindParam("date", $date, PDO::PARAM_STR);
        $query->bindParam("trx", $trx, PDO::PARAM_STR);
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
		$query->bindParam("remark", $remark, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read($month, $year, $filter, $m, $bank_name, $ledger)
    {	
		if($filter==2)
			$query = $this->db->prepare("SELECT * FROM bank WHERE month=:month AND year=:year AND bank_name= :bank_name AND ledger= :ledger AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		else
			$query = $this->db->prepare("SELECT * FROM bank WHERE month=:month AND year=:year AND bank_name= :bank_name AND ledger= :ledger ORDER BY date ASC, id ASC");
			
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	
	public function Read_Name($month, $year, $code, $ledger)
    {
    	$name="RUSAK";
        $query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND ledger= :ledger AND code>='10200' AND code<'10300'");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Opening($month, $year, $name, $ledger)
    {
        $query = $this->db->prepare("SELECT balance FROM coa WHERE month=:month AND year=:year AND name= :name AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		
        return $data;
    }
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function Delete($user_id)
    {
        $query = $this->db->prepare("DELETE FROM bank WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
    public function Update($date, $trx, $item, $code, $debet, $credit, $time, $remark, $username, $id)
    {
        $query = $this->db->prepare("UPDATE bank SET date= :date, trx= :trx, item= :item, code= :code, debet= :debet, credit= :credit,  time= :time, remark= :remark, created= :username WHERE id = :id");
        $query->bindParam("date", $date, PDO::PARAM_STR);
        $query->bindParam("trx", $trx, PDO::PARAM_STR);
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
		$query->bindParam("remark", $remark, PDO::PARAM_STR);
		$query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM bank WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year){
		$data='<h3>bank '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Date Transaction</th>
				<th>Transaction Record</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Remark</th>
				<th>Saldo</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Date Transaction</th>
				<th>Transaction Record</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Remark</th>
				<th>Saldo</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}
	public function show_data($number, $date, $trx, $item, $code, $name, $debet, $credit, $saldo, $remark, $id){
		
		$data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $date . '</td>
			<td>' . $trx . '</td>
			<td>' . $item . '</td>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . number_format($debet,2,",",".") . '</td>
			<td>' . number_format($credit,2,",",".") . '</td>
			<td>' . $remark . '</td>
			<td>' . number_format($saldo,2,",",".") . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
	
	public function bank_data($balance, $bank_name){
		
		$data='
		<tr>
			<td>' . 1 . '</td>
			<td></td>
			<td></td>
			<td>Opening Balance</td>
			<td></td>
			<td>'. $bank_name .'</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td>' . number_format(0,2,",",".") . '</td>
			<td></td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td>
				<button  class="btn btn-xs btn-warning buttton-update" disabled>Update</button>
			</td>
			<td>
				<button class="btn btn-xs btn-danger" disabled>Delete</button>
			</td>
		</tr>';
		return $data;
	}
	
	public function result($debet, $credit, $saldo){
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-right">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="debet">Total Debet:</label>
							<input type="text" id="debet" placeholder="" class="form-control" disabled/ value="'. number_format($debet,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="credit">Total Credit:</label>
							<input type="text" id="credit" placeholder="" class="form-control" disabled/ value="'. number_format($credit,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="difference">Total Saldo:</label>
							<input type="text" id="difference" placeholder="" class="form-control" disabled value="'. number_format($saldo,2,",",".") .'"/>
						</div>
					</div>
				</div>
			</div>
			';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}

class Adjustment
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
    public function Create($item, $code, $debet, $credit, $month, $year, $time, $ledger)
    {
        $query = $this->db->prepare("INSERT INTO adj(item, code, debet, credit, month, year, time, ledger) VALUES (:item, :code, :debet, :credit, :month, :year, :time, :ledger)");
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read($month, $year, $ledger)
    {	
		
		$query = $this->db->prepare("SELECT * FROM adj WHERE month= :month AND year= :year AND ledger= :ledger ORDER BY id ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Name($month, $year, $code, $ledger)
    {
        $query = $this->db->prepare("SELECT name FROM coa WHERE month= :month AND year= :year AND code= :code AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE month= :month AND year= :year AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function Delete($user_id)
    {
        $query = $this->db->prepare("DELETE FROM adj WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
    public function Update($item, $code, $debet, $credit, $time, $id)
    {
        $query = $this->db->prepare("UPDATE adj SET  item= :item, code= :code, debet= :debet, credit= :credit,  time= :time WHERE id = :id");
		$query->bindParam("item", $item, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("debet", $debet, PDO::PARAM_STR);
		$query->bindParam("credit", $credit, PDO::PARAM_STR);
		$query->bindParam("time", $time, PDO::PARAM_STR);
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM adj WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year){
		$data='<h3>Adjustment '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}
	public function show_data($number, $item, $code, $name, $debet, $credit, $id){
		
		$data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $item . '</td>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . number_format($debet,2,",",".") . '</td>
			<td>' . number_format($credit,2,",",".") . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
	
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}

class Journal
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read_Cash_Data($month, $year, $filter, $m, $code, $type, $ledger)
    {	
		if($filter==2){
			if($type==1){
				$query = $this->db->prepare("SELECT debet FROM cash WHERE ledger= :ledger AND debet!='0' AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
			}
			else{
				$query = $this->db->prepare("SELECT credit FROM cash WHERE ledger= :ledger AND credit!='0' AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
			}
		}
		else{
			if($type==1){
				$query = $this->db->prepare("SELECT debet FROM cash WHERE ledger= :ledger AND debet!='0' AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
			}
			else{
				$query = $this->db->prepare("SELECT credit FROM cash WHERE ledger= :ledger AND credit!='0' AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
			}
		}
			
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data($month, $year, $filter, $m, $bank_name, $code, $type, $ledger)
    {	
		if($filter==2){
			if($type==1){
				$query = $this->db->prepare("SELECT debet FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND debet!='0' AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
			}
			else{
				$query = $this->db->prepare("SELECT credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND credit!='0' AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
			}
		}
		else{
			if($type==1){
				$query = $this->db->prepare("SELECT debet FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND debet!='0' AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
			}
			else{
				$query = $this->db->prepare("SELECT credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND credit!='0' AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
			}
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Name($month, $year, $code, $ledger)
    {
        $query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE month= :month AND year= :year AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Cash($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Bank($month, $year, $name, $ledger)
    {
        $query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank($month, $year, $ledger)
    {
        $query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code>='10200' AND code<'10300' AND ledger= :ledger");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
   
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM bank WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year, $type, $name){
		if($type==1)
			$type="Incoming";
		else
			$type="Outgoing";
		
		if($name==1)
			$name="Cash on Hand";
		
		$data='<h3>Journal '. $type .' '. $name .' '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Item</th>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Debet</th>
				<th>Credit</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}
	public function show_data($item, $code, $name, $debet, $credit){
		
		$data='
		<tr>
			<td>' . $item . '</td>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' .number_format($debet,2,",",".") . '</td>
			<td>' . number_format($credit,2,",",".") . '</td>
		</tr>';
		return $data;
	}
	
	
	public function result($debet, $credit, $name, $type, $saldo){
		if($type==1)
			$debet=$saldo;
		else
			$credit=$saldo;
		if($name==1)
			$name="Cash On Hand";
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-right">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="name_journal">Name:</label>
							<input type="text" id="name_journal" placeholder="" class="form-control" disabled/ value="'. $name .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="debet">Debet:</label>
							<input type="text" id="debet" placeholder="" class="form-control" disabled/ value="'. number_format($debet,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="credit">Credit:</label>
							<input type="text" id="credit" placeholder="" class="form-control" disabled/ value="'. number_format($credit,2,",",".") .'">
						</div>
					</div>
				</div>
			</div>
			';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}

class PL
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
	 
	 public function Read_Adj_Data($month, $year, $code, $ledger)
    {	
		if($ledger != 7){
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE month=:month AND year=:year AND code= :code ");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
    public function Read_Cash_Data($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data($month, $year, $filter, $m, $bank_name, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $leedger, PDO::PARAM_STR);
			}
			
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data2($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Name($month, $year, $code, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code, balance, type, ledger FROM coa WHERE ledger=:ledger AND month=:month AND year=:year AND code> 40000 AND code< 70000 ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, balance, type, ledger FROM coa WHERE month=:month AND year=:year AND code> 40000 AND code< 70000 ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Cash($month, $year, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code> '10200' ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code> '10200' ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Bank($month, $year, $name, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank($month, $year, $ledger)
    {		
        $query = $this->db->prepare("SELECT code FROM coa WHERE month=:month AND year=:year AND code>='10200' AND code<'10300'");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
   
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
    public function Details($user_id)
    {
        $query = $this->db->prepare("SELECT * FROM bank WHERE id = :id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table($month, $year){
		$data='<h3>Profit and  Loss '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Nominal</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
		';
		return $data;
	}
	
	public function show0(){
		$data='<tr>
			<td colspan="4" style="font-size:1.2em;text-align:center;">Total Revenue</td>
		</tr>';
		return $data;
	}
	
	public function show1($total1){
		$data='<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal Revenue</td>
			<td>'. number_format($total1,2,",",".") .'</td>
		</tr>
		<tr> 
			<td colspan="4" style="font-size:1.2em;text-align:center;">Costs and Expenses</td>
		</tr>
		';
		return $data;
	}
	
	public function show2($total1, $total2){
		$result=$total1-$total2;
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal Costs and Expenses</td>
			<td>'. number_format($total2,2,",",".") .'</td>
		</tr>
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Operation Profit</td>
			<td>'. number_format($result,2,",",".") .'</td>
		</tr>
		<tr> 
			<td colspan="4" style="font-size:1.2em;text-align:center;">Other Revenue and Cost</td>
		</tr>
		';
		return $data;
	}
	
	public function show3($total1, $total2, $total3){
		$result=$total1-$total2;
		$result2=$result+$total3;
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal Other Revenue and Expenses</td>
			<td>'. number_format($total3,2,",",".") .'</td>
		</tr>
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Current Profit Month</td>
			<td>'. number_format($result2,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function show_data_right($code, $name, $balance){
		
		$data='
		<tr>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td></td>
			<td>' . number_format($balance,2,",",".") . '</td>
		</tr>';
		return $data;
	}
	
	public function show_data_left($code, $name, $balance){
		
		$data='
		<tr>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td></td>
		</tr>';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}

class NS
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
	 
	 public function Read_Adj_Data($month, $year, $code, $ledger)
    {	
		if($ledger != 7){
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE month=:month AND year=:year AND code= :code AND ledger= :ledger");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE month=:month AND year=:year AND code= :code");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
    public function Read_Cash_Data($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data($month, $year, $filter, $m, $bank_name, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE bank_name= :bank_name AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data2($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else{
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");		
			}			
		}
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Name($month, $year, $code, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code, balance, ledger, type FROM coa WHERE ledger= :ledger AND month=:month AND year=:year ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, balance, ledger, type FROM coa WHERE month=:month AND year=:year ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Cash($month, $year, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code>'10200' ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Bank($month, $year, $name, $ledger)
    {
		if($ledger != 7){
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger=:ledger AND month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' AND code<'10300'");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT code FROM coa WHERE month=:month AND year=:year AND code>'10200' AND code<'10300'");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
   
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
	
	public function table($month, $year){
		$data='<h3>Neraca Saldo '. $month .' - '. $year .':</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Account Type</th>
				<th>Opening Balance</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Balance</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Account Type</th>
				<th>Opening Balance</th>
				<th>Debet</th>
				<th>Credit</th>
				<th>Balance</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}
	public function show_data($code, $name, $type, $opening, $debet, $credit, $balance){
		
		$data='
		<tr>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . $type . '</td>
			<td>' .number_format($opening,2,",",".") . '</td>
			<td>' .number_format($debet,2,",",".") . '</td>
			<td>' . number_format($credit,2,",",".") . '</td>
			<td>' . number_format($balance,2,",",".") . '</td>
		</tr>';
		return $data;
	}
	
	
	public function result($opening, $debet, $credit, $balance){
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-right">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="opening_result">Opening balance:</label>
							<input type="text" id="opening_result" placeholder="" class="form-control" disabled/ value="'. number_format($opening,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="debet_result">Debet:</label>
							<input type="text" id="debet_result" placeholder="" class="form-control" disabled/ value="'. number_format($debet,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="credit_result">Credit:</label>
							<input type="text" id="credit_result" placeholder="" class="form-control" disabled/ value="'. number_format($credit,2,",",".") .'">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="balance_result">Balance:</label>
							<input type="text" id="balance_result" placeholder="" class="form-control" disabled/ value="'. number_format($balance,2,",",".") .'">
						</div>
					</div>
				</div>
			</div>
			';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
}
 
class NRC
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
	
    /*
     * Add new Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
	 
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
	  public function Create($code, $name, $type, $balance, $remark, $month, $year, $ledger)
    {
        $query = $this->db->prepare("INSERT INTO coa(code, name,  type, balance, remark, month, year, ledger) VALUES (:code, :name, :type, :balance, :remark, :month, :year, :ledger)");
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("type", $type, PDO::PARAM_STR);
		$query->bindParam("balance", $balance, PDO::PARAM_STR);
		$query->bindParam("remark", $remark, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
	
	 public function Read_Adj_Data($month, $year, $code, $ledger)
    {	
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT debet, credit FROM adj WHERE month=:month AND year=:year AND code= :code ");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
    public function Read_Cash_Data($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){	
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM cash WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data($month, $year, $filter, $m, $bank_name, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){	
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND bank_name= :bank_name AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE bank_name= :bank_name AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("bank_name", $bank_name, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank_Data2($month, $year, $filter, $m, $code, $ledger)
    {	
		if($filter==2){
			$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code AND date<'". $year. "-". $m ."-16' ORDER BY date ASC, id ASC");
		}
		else{
			if($ledger != 7){	
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
				$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
			}
			else
				$query = $this->db->prepare("SELECT debet, credit FROM bank WHERE month=:month AND year=:year AND code= :code ORDER BY date ASC, id ASC");
		}
		
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Name($month, $year, $code, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code= :code");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR); 
		}
		else
			$query = $this->db->prepare("SELECT name FROM coa WHERE month=:month AND year=:year AND code= :code");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("code", $code, PDO::PARAM_STR); 
        $query->execute(); 
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
		foreach($data as $d){
			$name=$d['name'];
		}
        return $name;
    }
	
	public function Read_Code_Pl($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code, balance, type FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code> 40000 AND code<70000 ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, balance, type FROM coa WHERE month=:month AND year=:year AND code> 40000 AND code<70000 ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Code($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code, balance, type, ledger FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code> 10000 AND code<40000 ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, balance, type, ledger FROM coa WHERE month=:month AND year=:year AND code> 10000 AND code<40000 ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Code_Closing($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code, type FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>40000 ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, type FROM coa WHERE month=:month AND year=:year AND code>40000 ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Code2($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code, balance, type FROM coa WHERE ledger= :ledger AND month=:month AND year=:year ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code, balance, type FROM coa WHERE month=:month AND year=:year ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Cash($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code>'10200' ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Coa_Bank($month, $year, $name, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT name, code FROM coa WHERE month=:month AND year=:year AND code>'10200' AND name!=:name ORDER BY code ASC");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function Read_Bank($month, $year, $ledger)
    {
		if($ledger != 7){	
			$query = $this->db->prepare("SELECT code FROM coa WHERE ledger= :ledger AND month=:month AND year=:year AND code>'10200' AND code<'10300'");
			$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
		}
		else
			$query = $this->db->prepare("SELECT code FROM coa WHERE month=:month AND year=:year AND code>'10200' AND code<'10300'");
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
	
 
    /*
     * Delete Record
     *
     * @param $user_id
     * */
 
    /*
     * Update Record
     *
     * @param $code
     * @param $name
     * @param $tahun_aka
	 * @param $type
	 * @param $remark
	 * @param $gel
	 * @param $month
	 * @param $year
     * @return $mixed
     * */
   
 
    /*
     * Get Details
     *
     * @param $user_id
     * */
	
	public function table_left($month, $year){
		$data='
		<h3>Neraca '. $month .' - '. $year .'</h3>
		<div class="col-md-6">
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Nominal</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
		';
		return $data;
	}
	
	public function table_right(){
		$data='
		<div class="col-md-6">
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable2" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>Account Code</th>
				<th>Account Name</th>
				<th>Nominal</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
		';
		return $data;
	}
	
	public function show0(){
		$data='<tr>
			<td colspan="4" style="font-size:1.2em;text-align:center;">Total Revenue</td>
		</tr>';
		return $data;
	}
	
	public function show1($total1){
		$data='<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal </td>
			<td>'. number_format($total1,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function show2($total2){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal </td>
			<td>'. number_format($total2,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function result_left($total){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Total </td>
			<td>'. number_format($total,2,",",".") .'</td>
		</tr>
		</tbody></table></div></div>';
		
		return $data;
	}
	
	public function result_right($total){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Total </td>
			<td>'. number_format($total,2,",",".") .'</td>
		</tr>
		</tbody></table></div></div>';
		
		return $data;
	}
	
	public function show3($total3){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal </td>
			<td>'. number_format($total3,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function show4($total4){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal Liabilities </td>
			<td>'. number_format($total4,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function show5($total5){
		$data='
		<tr>
			<td colspan="3" style="font-size:1.2em;text-align:center;">Subtotal Capital </td>
			<td>'. number_format($total5,2,",",".") .'</td>
		</tr>
		';
		return $data;
	}
	
	public function show_data_right($code, $name, $balance){
		
		$data='
		<tr>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td></td>
			<td>' . number_format($balance,2,",",".") . '</td>
		</tr>';
		return $data;
	}
	
	public function show_data_left($code, $name, $balance){
		
		$data='
		<tr>
			<td>' . $code . '</td>
			<td>' . $name . '</td>
			<td>' . number_format($balance,2,",",".") . '</td>
			<td></td>
		</tr>';
		return $data;
	}
	
	public function end_data($data1, $data2){
		$balance="Not Balance";
		if($data1==$data2)
			$balance="Balance";
		$data='
		<div class="row">
			<div class="col-md-12 ">
				<div class="pull-left">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="credit_result">Status:</label>
							<input type="text" id="credit_result" placeholder="" class="form-control" disabled/ value="'. $balance .'">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="balance_result">Balance:</label>
							<input type="text" id="balance_result" placeholder="" class="form-control" disabled/ value="'. number_format($data1-$data2,2,",",".") .'">
						</div>
					</div>
				</div>
			</div>
		
		';
		return $data;
	}
	
	public function month($month){
		if($month=="January")
            $result="01";
        else if($month=="February")
            $result="02";
        else if($month=="March")
            $result="03";
        else if($month=="April")
            $result="04";
        else if($month=="May")
            $result="05";
        else if($month=="June")
            $result="06";
        else if($month=="July")
            $result="07";
        else if($month=="August")
            $result="08";
        else if($month=="September")
            $result="09";
        else if($month=="October")
            $result="10";
        else if($month=="November")
            $result="11";
        else
            $result="12";
        return $result;
	}
	
	public function check_month($month){
		if($month=="January")
            $result="February";
        else if($month=="February")
            $result="March";
        else if($month=="March")
            $result="April";
        else if($month=="April")
            $result="May";
        else if($month=="May")
            $result="June";
        else if($month=="June")
            $result="July";
        else if($month=="July")
            $result="August";
        else if($month=="August")
            $result="September";
        else if($month=="September")
            $result="October";
        else if($month=="October")
            $result="November";
        else if($month=="November")
            $result="December";
        else
            $result="January";
        return $result;
	}
	
	public function check_year($month){
		$result=1;
		if($month!="January")
			$result=0;
		return $result;
	}
	
	public function Create_Coa($code, $name, $type, $balance, $month, $year, $ledger)
    {
		
        $query = $this->db->prepare("INSERT INTO coa(code, name, type, balance, month, year, ledger) VALUES (:code, :name, :type, :balance, :month, :year, :ledger)");
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("type", $type, PDO::PARAM_STR);
		$query->bindParam("balance", $balance, PDO::PARAM_STR);
		$query->bindParam("month", $month, PDO::PARAM_STR);
		$query->bindParam("year", $year, PDO::PARAM_STR);
		$query->bindParam("ledger", $ledger, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
}
 
?>