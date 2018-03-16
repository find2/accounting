<?php
 
require __DIR__ . '/db_connection.php';
 
class Supplier
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
 
	
	 
    public function Create($name, $phone)
    {
        $query = $this->db->prepare("INSERT INTO supplier(name, phone) VALUES (:name, :phone)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("phone", $phone, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read()
    {
        $query = $this->db->prepare("SELECT * FROM supplier");
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
        $query = $this->db->prepare("DELETE FROM supplier WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
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
    public function Update($id, $name, $phone)
    {
        $query = $this->db->prepare("UPDATE supplier SET name=:name, phone= :phone WHERE id = :id");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("phone", $phone, PDO::PARAM_STR);
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
        $query = $this->db->prepare("SELECT * FROM supplier WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table(){
		$data='<h3>Supplier List</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Supplier Name</th>
				<th>Phone Number</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Supplier Name</th>
				<th>Phone Number</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}

	public function show_data($number, $name, $phone, $id){	
		$data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $name . '</td>
			<td>' . $phone . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
}
 
class Item_Master
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
 
	
	 
    public function Create($name, $code)
    {
        $query = $this->db->prepare("INSERT INTO item_master(name, code) VALUES (:name, :code)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("code", $code, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    
    /*
    * Read all records
    *
    * @return $mixed
    * */
    public function Read()
    {
        $query = $this->db->prepare("SELECT * FROM item_master");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function Get_Id_Master($id)
    {
        $query = $this->db->prepare("SELECT id_master FROM item_stock 
        WHERE id= :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $data = $dat['id_master'];
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
        $query = $this->db->prepare("DELETE FROM item_master WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
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
    public function Update($id, $name, $code)
    {
        $query = $this->db->prepare("UPDATE item_master SET name=:name, code= :code WHERE id = :id");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("code", $code, PDO::PARAM_STR);
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
        $query = $this->db->prepare("SELECT * FROM item_master WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table(){
		$data='<h3>Master Item</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Item Name</th>
				<th>Item Code</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Item Name</th>
				<th>Item Code</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}

	public function show_data($number, $name, $code, $id){	
		$data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $name . '</td>
			<td>' . $code . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
}

class Item_Stock
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
 
	
	 
    public function Create($id_master, $id_supplier, $qty, $buy, $sell, $name)
    {
        $query = $this->db->prepare("INSERT INTO item_stock(id_master, id_supplier, qty, buy, sell, name) VALUES (:id_master, :id_supplier, :qty, :buy, :sell, :name)");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->bindParam("buy", $buy, PDO::PARAM_STR);
        $query->bindParam("sell", $sell, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
 
    /*
     * Read all records
     *
     * @return $mixed
     * */
    public function Read()
    {
        $query = $this->db->prepare("SELECT supplier.name AS supplier_name, item_master.code, item_stock.name, item_stock.qty, item_stock.buy, item_stock.sell, item_stock.id
        FROM ((item_stock
            INNER JOIN supplier ON item_stock.id_supplier = supplier.id)
            INNER JOIN item_master ON item_stock.id_master = item_master.id)");
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
        $query = $this->db->prepare("DELETE FROM item_stock WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
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
    public function Update($id, $id_master, $id_supplier, $qty, $buy, $sell, $name)
    {
        $query = $this->db->prepare("UPDATE item_stock SET id_master= :id_master, id_supplier= :id_supplier, qty= :qty, buy= :buy, sell= :sell, name= :name WHERE id = :id");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->bindParam("buy", $buy, PDO::PARAM_STR);
        $query->bindParam("sell", $sell, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
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
        $query = $this->db->prepare("SELECT * FROM item_stock WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function table(){
		$data='<h3>Stock Item</h3>
		<div class="table-responsive">
		<table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
		<thead>
			<tr class="header">
				<th>No.</th>
				<th>Item Name</th>
				<th>Qty</th>
				<th>Supplier</th>
				<th>Purchase Price</th>
				<th>Selling Price</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>No.</th>
				<th>Item Name</th>
				<th>Qty</th>
				<th>Supplier</th>
				<th>Purchase Price</th>
				<th>Selling Price</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
		';
		return $data;
	}

	public function show_data($number, $code, $name, $supplier_name, $qty, $buy, $sell, $id){	
        $name = $code."_".$name;
        $data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $name . '</td>
			<td>' . $qty . '</td>
			<td>' . $supplier_name . '</td>
			<td>' . number_format($buy,2,",",".") . '</td>
			<td>' . number_format($sell,2,",",".") . '</td>
			<td>
				<button onclick="GetUserDetails(' . $id . ')" class="btn btn-xs btn-warning buttton-update">Update</button>
			</td>
			<td>
				<button onclick="DeleteUser(' . $id . ')" class="btn btn-xs btn-danger" >Delete</button>
			</td>
		</tr>';
		return $data;
	}
}

class Item_Po_Inv
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
 
	
	 
    public function Create_Po_Inv($title, $id_supplier, $status, $date_created)
    {
        $query = $this->db->prepare("INSERT INTO po_inv(title, id_supplier, status, date_created) VALUES (:title, :id_supplier, :status, :date_created)");
        $query->bindParam("title", $title, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("date_created", $date_created, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    
    public function Update_Po_Inv($id, $title, $id_supplier, $status, $date_created)
    {
        $query = $this->db->prepare("UPDATE po_inv SET title = :title, id_supplier = :id_supplier, status = :status, date_created = :date_created WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("title", $title, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("date_created", $date_created, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function Create_Item_Po_Inv($id_po_inv, $id_item_stock, $id_master, $qty, $buy, $sell, $name)
    {
        if($id_item_stock!=0)
            $name = $this->Read_Item_Stock_Name($id_item_stock);
        $query = $this->db->prepare("INSERT INTO item_po_inv(id_po_inv, id_item_stock, id_master, qty, buy, sell, name) VALUES (:id_po_inv, :id_item_stock, :id_master, :qty, :buy, :sell, :name)");
        $query->bindParam("id_po_inv", $id_po_inv, PDO::PARAM_STR);
        $query->bindParam("id_item_stock", $id_item_stock, PDO::PARAM_STR);
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->bindParam("buy", $buy, PDO::PARAM_STR);
        $query->bindParam("sell", $sell, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    
    /*
    * Read all records
    *
    * @return $mixed
    * */
    public function Read_Item_Stock_Name($id){
        $name = "";
        $query = $this->db->prepare("SELECT name
        FROM item_stock
        WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $name = $dat['name'];
        }
        return $name;
    }

    public function Read_Item_stock_Id($id)
    {
        $query = $this->db->prepare("SELECT buy, sell, id
        FROM item_stock
        WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function Read_Item_stock_Id_Master($id_master)
    {
        $query = $this->db->prepare("SELECT item_master.code, item_stock.name, item_stock.id
        FROM (item_stock
            INNER JOIN item_master ON item_stock.id_master = item_master.id
            ) WHERE item_stock.id_master = :id_master");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function Read_PO($status){
        $query = $this->db->prepare("SELECT po_inv.id, po_inv.title, po_inv.date_created, supplier.name
        FROM po_inv, supplier
        WHERE po_inv.id_supplier = supplier.id AND po_inv.status= :status 
        ORDER BY po_inv.id DESC ");
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function Read_PO_Item($id, $status)
    {
        $query = $this->db->prepare("SELECT DISTINCT po_inv.id, po_inv.status, supplier.name AS supplier_name, item_master.code, item_po_inv.name, item_po_inv.qty, item_po_inv.buy, item_po_inv.sell 
        FROM item_po_inv, po_inv, supplier, item_master 
        WHERE item_po_inv.id_po_inv = po_inv.id AND item_po_inv.id_master = item_master.id AND po_inv.id_supplier = supplier.id AND item_po_inv.id_po_inv = :id AND po_inv.status= :status ");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
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
        $query = $this->db->prepare("DELETE FROM po_inv WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
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
    public function Move_To_Inv($id)
    {
        $query = $this->db->prepare("UPDATE po_inv SET status = 1
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }

    public function Get_Supplier($id){
        $query = $this->db->prepare("SELECT id_supplier FROM po_inv      
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $dat = $dat['id_supplier'];
        }
        return $dat;
    }

    public function Get_Current_Stock($id){
        $query = $this->db->prepare("SELECT qty FROM item_stock      
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function Move_Item($id)
    {
        $id_supplier = $this->Get_Supplier($id);
        $query = $this->db->prepare("SELECT * FROM item_po_inv      
        WHERE id_po_inv = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $inv){
            if($inv['id_item_stock'] != 0){
                $stocks = $this->Get_Current_Stock($inv['id_item_stock']);
                foreach($stocks as $stock){
                    $qty = $stock['qty']+$inv['qty'];
                }
                $query = $this->db->prepare("UPDATE item_stock 
                SET   qty= :qty, buy = :buy, sell = :sell, name= :name, id_supplier= :id_supplier
                WHERE id = :id_item_stock");
                $query->bindParam("id_item_stock", $inv['id_item_stock'], PDO::PARAM_STR);
                $query->bindParam("qty", $qty, PDO::PARAM_STR);
                $query->bindParam("buy", $inv['buy'], PDO::PARAM_STR);
                $query->bindParam("sell", $inv['sell'], PDO::PARAM_STR);
                $query->bindParam("name", $inv['name'], PDO::PARAM_STR);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->execute();
            }
            else{
                $query = $this->db->prepare("INSERT INTO item_stock(qty, buy, sell, name, id_supplier, id_master) VALUES (:qty, :buy, :sell, :name, :id_supplier, :id_master)");
                $query->bindParam("qty", $inv['qty'], PDO::PARAM_STR);
                $query->bindParam("buy", $inv['buy'], PDO::PARAM_STR);
                $query->bindParam("sell", $inv['sell'], PDO::PARAM_STR);
                $query->bindParam("name", $inv['name'], PDO::PARAM_STR);
                $query->bindParam("id_master", $inv['id_master'], PDO::PARAM_STR);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->execute();
            }
        }
    }
    
    public function Update($id,$id_item_stock, $id_master, $id_supplier, $qty, $buy, $sell, $name)
    {
        $query = $this->db->prepare("UPDATE item_stock SET id_master= :id_master, id_supplier= :id_supplier, qty= :qty, buy= :buy, sell= :sell, name= :name WHERE id = :id");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->bindParam("buy", $buy, PDO::PARAM_STR);
        $query->bindParam("sell", $sell, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
    
    public function Read_Total_PO($id)
    {
        $query = $this->db->prepare("SELECT count(id_po_inv) AS id_po_inv FROM item_po_inv WHERE id_po_inv = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $data = $dat['id_po_inv'];
        }
        return $data;
    }
    
    /*
    * Get Details
    *
    * @param $user_id
    * */
    public function Details($id)
    {
        $query = $this->db->prepare("SELECT * FROM po_inv WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
    
    public function Details_Item_PO($id)
    {
        $query = $this->db->prepare("SELECT * FROM item_po_inv WHERE id_po_inv = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        // return $data;
        return json_encode($data, JSON_FORCE_OBJECT);
        // return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function Start_Table(){
        
		$data = '
		<div class="table-responsive">
            <table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
            <thead>
                <tr class="header">
                    <th>No.</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                </tr>
            </thead>
            <tbody>
		';
		return $data;
	}

	public function Show_Data($number, $code, $name, $qty, $buy, $sell){	
        $name = $code."_". $name;
        $data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $name . '</td>
			<td>' . $qty . '</td>
			<td>' . number_format($buy,2,",",".") . '</td>
			<td>' . number_format($sell,2,",",".") . '</td>
		</tr>';
		return $data;
    }
    
    public function End_Table($id, $status){
        $data = '
            </tbody>
        </table>
        </div>
        ';
        $data2 = '
        <div class="row">
            <div class="col-lg-4">
                <button onclick="moveToInv(' . $id . ')" class="btn btn-block btn-md btn-info">Move To Invoice</button>
            </div>
            <div class="col-lg-4">
                <button onclick="GetUserDetails(' . $id . ')" class="btn btn-block btn-md btn-warning">Update</button>
            </div>
            <div class="col-lg-4">
                <button onclick="DeleteUser(' . $id . ')" class="btn btn-block btn-md btn-danger" >Delete</button>
            </div>
        </div>';
        if($status==0)
            $data .= $data2;
        return $data;
    }
}
class Billing
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
 
	
	 
    public function Create_Billing($title, $monarch, $status, $date_created)
    {
        $query = $this->db->prepare("INSERT INTO billing(title, monarch, status, date_created) VALUES (:title, :monarch, :status, :date_created)");
        $query->bindParam("title", $title, PDO::PARAM_STR);
        $query->bindParam("monarch", $monarch, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("date_created", $date_created, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    
    public function Update_Po_Inv($id, $title, $id_supplier, $status, $date_created)
    {
        $query = $this->db->prepare("UPDATE po_inv SET title = :title, id_supplier = :id_supplier, status = :status, date_created = :date_created WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("title", $title, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("date_created", $date_created, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function Get_Qty_Item_Billing($id_billing, $id_item_stock){
        $query = $this->db->prepare("SELECT qty FROM item_billing      
        WHERE id_billing = :id_billing AND id_item_stock = :id_item_stock");
		$query->bindParam("id_billing", $id_billing, PDO::PARAM_STR);
		$query->bindParam("id_item_stock", $id_item_stock, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $data = $dat['qty'];
        }
        return $data;
    }

    public function Create_Item_Billing($id_billing, $id_item_stock, $qty)
    {
        $query = $this->db->prepare("INSERT INTO item_billing(id_billing, id_item_stock, qty) 
        VALUES (:id_billing, :id_item_stock, :qty)");
        $query->bindParam("id_billing", $id_billing, PDO::PARAM_STR);
        $query->bindParam("id_item_stock", $id_item_stock, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->execute();

        $qty_stock = $this->Get_Current_Stock($id_item_stock);
        $qty_stock -= $qty;

        $query = $this->db->prepare("UPDATE item_stock SET qty= :qty2 
        WHERE  id= :id");
        $query->bindParam("id", $id_item_stock, PDO::PARAM_STR);
        $query->bindParam("qty2", $qty_stock, PDO::PARAM_STR);
        $query->execute();
        // return $this->db->lastInsertId();
    }
    
    /*
    * Read all records
    *
    * @return $mixed
    * */
    public function Read_Item_Stock_Name($id){
        $name = "";
        $query = $this->db->prepare("SELECT name
        FROM item_stock
        WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $name = $dat['name'];
        }
        return $name;
    }

    public function Read_Item_stock_Id($id)
    {
        $query = $this->db->prepare("SELECT buy, sell, id
        FROM item_stock
        WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function Read_Item_stock_Id_Master($id_master)
    {
        $query = $this->db->prepare("SELECT item_master.code, item_stock.name, item_stock.id
        FROM (item_stock
            INNER JOIN item_master ON item_stock.id_master = item_master.id
            ) WHERE item_stock.id_master = :id_master");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function Monarch($i){
        if($i == 1)
            $data = "Monarch Dalung";
        else if($i == 2)
            $data = "Monarch Candidasa";
        else if($i == 3)
            $data = "Monarch Singaraja";
        else if($i == 4)
            $data = "Monarch Gianyar";
        else
            $data = "Monarch Negara";
        return $data;
    }
    
    public function Read_Billing($status){
        $query = $this->db->prepare("SELECT id, title, date_created, monarch
        FROM billing
        WHERE status= :status 
        ORDER BY id DESC ");
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function Read_Billing_Item($id, $status)
    {
        $query = $this->db->prepare("SELECT DISTINCT item_billing.id, item_billing.qty, item_stock.name, item_stock.sell, item_master.code 
        FROM item_billing, item_stock, item_master, billing
        WHERE item_billing.id_billing = billing.id AND item_billing.id_item_stock = item_stock.id AND item_stock.id_master = item_master.id AND item_billing.id_billing = :id AND billing.status= :status ");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
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
        $query = $this->db->prepare("DELETE FROM billing WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
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
    public function Move_To_Paid($id)
    {
        $query = $this->db->prepare("UPDATE billing SET status = 1
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }

    public function Get_Supplier($id){
        $query = $this->db->prepare("SELECT id_supplier FROM po_inv      
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $dat = $dat['id_supplier'];
        }
        return $dat;
    }

    public function Restore_Qty($id_billing){
        $query = $this->db->prepare("SELECT qty, id_item_stock FROM item_billing      
        WHERE id_billing = :id_billing");
		$query->bindParam("id_billing", $id_billing, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $qty = $this->Get_Current_Stock($dat['id_item_stock']);
            $qty += $dat['qty'];

            $query = $this->db->prepare("UPDATE item_stock SET qty= :qty 
            WHERE  id= :id");
            $query->bindParam("id", $dat['id_item_stock'], PDO::PARAM_STR);
            $query->bindParam("qty", $qty, PDO::PARAM_STR);
            $query->execute();

        }
    }


    public function Get_Current_Stock($id){
        $query = $this->db->prepare("SELECT qty FROM item_stock      
        WHERE id = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $qty = $dat['qty'];
        }
        return $qty;
    }

    public function Move_Item($id)
    {
        $id_supplier = $this->Get_Supplier($id);
        $query = $this->db->prepare("SELECT * FROM item_po_inv      
        WHERE id_po_inv = :id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $inv){
            if($inv['id_item_stock'] != 0){
                $stocks = $this->Get_Current_Stock($inv['id_item_stock']);
                foreach($stocks as $stock){
                    $qty = $stock['qty']+$inv['qty'];
                }
                $query = $this->db->prepare("UPDATE item_stock 
                SET   qty= :qty, buy = :buy, sell = :sell, name= :name, id_supplier= :id_supplier
                WHERE id = :id_item_stock");
                $query->bindParam("id_item_stock", $inv['id_item_stock'], PDO::PARAM_STR);
                $query->bindParam("qty", $qty, PDO::PARAM_STR);
                $query->bindParam("buy", $inv['buy'], PDO::PARAM_STR);
                $query->bindParam("sell", $inv['sell'], PDO::PARAM_STR);
                $query->bindParam("name", $inv['name'], PDO::PARAM_STR);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->execute();
            }
            else{
                $query = $this->db->prepare("INSERT INTO item_stock(qty, buy, sell, name, id_supplier, id_master) VALUES (:qty, :buy, :sell, :name, :id_supplier, :id_master)");
                $query->bindParam("qty", $inv['qty'], PDO::PARAM_STR);
                $query->bindParam("buy", $inv['buy'], PDO::PARAM_STR);
                $query->bindParam("sell", $inv['sell'], PDO::PARAM_STR);
                $query->bindParam("name", $inv['name'], PDO::PARAM_STR);
                $query->bindParam("id_master", $inv['id_master'], PDO::PARAM_STR);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->execute();
            }
        }
    }
    
    public function Update($id,$id_item_stock, $id_master, $id_supplier, $qty, $buy, $sell, $name)
    {
        $query = $this->db->prepare("UPDATE item_stock SET id_master= :id_master, id_supplier= :id_supplier, qty= :qty, buy= :buy, sell= :sell, name= :name WHERE id = :id");
        $query->bindParam("id_master", $id_master, PDO::PARAM_STR);
        $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        $query->bindParam("qty", $qty, PDO::PARAM_STR);
        $query->bindParam("buy", $buy, PDO::PARAM_STR);
        $query->bindParam("sell", $sell, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
		$query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
    
    public function Read_Total_Billing($id)
    {
        $query = $this->db->prepare("SELECT count(id_billing) AS id_billing FROM item_billing WHERE id_billing = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach($data as $dat){
            $data = $dat['id_billing'];
        }
        return $data;
    }
    
    /*
    * Get Details
    *
    * @param $user_id
    * */
    public function Details($id)
    {
        $query = $this->db->prepare("SELECT * FROM billing WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
    
    public function Details_Item_Billing($id)
    {
        $query = $this->db->prepare("SELECT * FROM item_billing WHERE id_billing = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        // return $data;
        return json_encode($data, JSON_FORCE_OBJECT);
        // return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
	
	public function Start_Table(){
        
		$data = '
		<div class="table-responsive">
            <table class="table table-bordered table-striped" id="myTable" width="100%" cellspacing="0">
            <thead>
                <tr class="header">
                    <th>No.</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
		';
		return $data;
	}

	public function Show_Data($number, $code, $name, $qty, $sell){	
        $name = $code."_". $name;
        $data='
		<tr>
			<td>' . $number . '</td>
			<td>' . $name . '</td>
			<td>' . $qty . '</td>
			<td>' . number_format($sell,2,",",".") . '</td>
			<td>' . number_format($sell*$qty,2,",",".") . '</td>
		</tr>';
		return $data;
    }
    
    public function End_Table($id, $status){
        $data = '
            </tbody>
        </table>
        </div>
        ';
        $data2 = '
        <div class="row">
            <div class="col-lg-4">
                <button onclick="moveToPaid(' . $id . ')" class="btn btn-block btn-md btn-info">Move To Paid Bill</button>
            </div>
            <div class="col-lg-4">
                <button onclick="GetUserDetails(' . $id . ')" class="btn btn-block btn-md btn-warning">Update</button>
            </div>
            <div class="col-lg-4">
                <button onclick="DeleteUser(' . $id . ')" class="btn btn-block btn-md btn-danger" >Delete</button>
            </div>
        </div>';
        if($status==0)
            $data .= $data2;
        return $data;
    }
}
?>