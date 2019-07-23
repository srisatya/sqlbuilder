<?php
/*
Author: Madiyasa
Simple Class: DB query built in
driver: mysqli
year:2019
*/
class DB
{
  public $connect;
  public $table;
  public function __construct($host,$uname,$upass,$dbname)
	{
		if($conn=mysqli_connect($host,$uname,$upass,$dbname))
		{
			$this->connect = $conn;
		}else
		{
			$this->connect=false;
		}	
	}	
	
	public function table($dbname)
	{
		$this->table = new table($dbname);
		$this->table->conn = $this->connect;
		return $this->table;
	}
}

class table
{
	protected $select;
	protected $dbname;
	protected $insert;
	protected $replace;
	protected $update;
	protected $delete;
	protected $query;
	public $conn;
	public function __construct($dbname)
	{
		$this->dbname = $dbname;
		//$this->conn = $this->connect;
		
	}
	
	public function select($args='')
	{
		$this->select = new select($args);
		$this->select->dbname = $this->dbname;
		$this->select->conn = $this->conn;
		return $this->select;
	}
	
	public function insert()
	{
		$this->insert = new insert($this->dbname);
		$this->insert->dbname = $this->dbname;
		$this->insert->conn = $this->conn;
		return $this->insert;
	}
	public function replace()
	{
		$this->replace = new replace($this->dbname);
		$this->replace->dbname = $this->dbname;
		$this->replace->conn = $this->conn;
		return $this->replace;
	}
	
	public function update()
	{
		$this->update = new update($this->dbname);
		$this->update->dbname = $this->dbname;
		$this->update->conn = $this->conn;
		return $this->update;
	}
	
	public function delete()
	{
		$this->delete = new delete($this->dbname);
		$this->delete->dbname = $this->dbname;
		$this->delete->conn = $this->conn;
		return $this->delete;
	}
	
	public function query($query='',$args='')
	{
		$this->query = new query($query,$args);
		$this->query->dbname = $this->dbname;
		$this->query->conn = $this->conn;
		return $this->query;
	}
	
	
}




class insert
{
	public $dbname;
	public $command;
	protected $newcommand;
	public $conn;
	public function __construct($dbname)
	{
	  $this->command =	"INSERT INTO $dbname";
	}
	
	public function colums($args=[])
	{
	  $rsl='';
		if(is_array($args))
		{
			if(count($args)> 0)
			{
				$rsl = implode(',',$args);
			}
				
		}
	  	
		$this->newcommand = "(".$rsl.")";
		return $this;
	}
	
	public function values($args=[])
	{
	  $rsl=[];
	  $str='';
		if(is_array($args))
		{
			if(count($args)> 0)
			{
				foreach($args as $arg)
					$rsl[] = "'".$arg."'";
					
				$str = " VALUES(".implode(',',$rsl).")";
			}
				
		}
	  	
		$this->newcommand = $this->newcommand .$str;
		return $this;	
	}
	
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}


class replace
{
	public $dbname;
	public $command;
	protected $newcommand;
	public $conn;
	public function __construct($dbname)
	{
	  $this->command =	"REPLACE INTO $dbname";
	}
	
	public function colums($args=[])
	{
	  $rsl='';
		if(is_array($args))
		{
			if(count($args)> 0)
			{
				$rsl = implode(',',$args);
			}
				
		}
	  	
		$this->newcommand = "(".$rsl.")";
		return $this;
	}
	
	public function values($args=[])
	{
	  $rsl=[];
	  $str='';
		if(is_array($args))
		{
			if(count($args)> 0)
			{
				foreach($args as $arg)
					$rsl[] = "'".$arg."'";
					
				$str = " VALUES(".implode(',',$rsl).")";
			}
				
		}
	  	
		$this->newcommand = $this->newcommand .$str;
		return $this;	
	}
	
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}

class update
{
	public $dbname;
	public $command;
	protected $newcommand;
	public $conn;
	public function __construct($dbname)
	{
	  $this->command =	"UPDATE $dbname";
	}
	
	public function setValue($args=[])
	{
		$str='';
		$arr=[];
		if(is_array($args))
		{
			if(count($args) > 0)
			{
				foreach($args as $key=>$arg)
				{
					$arr[] =$key ." = '".$arg."'"; 
				}
				
				$str = " SET ".implode(",",$arr);
				
			}
			
		}
		
		$this->newcommand = $this->newcommand .$str;
		return $this;
	}	
	
	public function where($col,$tanda,$val)
	{
		$this->where = new where($col,$tanda,$val);
		$this->where->command=$this->command . $this->newcommand ." WHERE ";
		$this->where->dbname = $this->dbname;
		return $this->where;
	}
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}


class delete
{
	public $dbname;
	public $command;
	protected $newcommand;
	public $conn;
	public function __construct($dbname)
	{
	  $this->command =	"DELETE FROM $dbname";
	}
	
	
	public function where($col,$tanda,$val)
	{
		$this->where = new where($col,$tanda,$val);
		$this->where->command=$this->command . $this->newcommand ." WHERE ";
		$this->where->dbname = $this->dbname;
		return $this->where;
	}
	
	
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}


class query
{
	public $dbname;
	public $command;
	protected $newcommand;
	public $conn;
	public function __construct($query,$args='')
	{
		if(strtoupper($query) == "SELECT")
		{
			if(isset($args) && !empty($args))
				$args = $args;
			else
				$args = '*';
	         $this->command =	"SELECT $args FROM ".$this->dbname." ";
		}
		else if(strtoupper($query) == "INSERT")
		{
		      $this->command =	"INSERT INTO ".$this->dbname."";
		}
        else if(strtoupper($query) == "REPLACE")
		{      $this->command =	"REPLACE INTO ".$this->dbname." ";
		}
		else if(strtoupper($query) == "UPDATE")
		{			  $this->command =	"UPDATE ".$this->dbname." SET ";
		}
		else if(strtoupper($query) == "DELETE")
		{			  $this->command =	"DELETE FROM ".$this->dbname." ";
		}else
		{			  $this->command =	$args;
		}
		
	}
	
	public function statement($st='')
	{
		
		$this->newcommand = $st;
		return $this;
	}
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
	public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
	
}

class select
{
	public $dbname;
	protected $select;
	public $where;
	public $orderby;
	public $limit;
	public $groupby;
	public $joinOn;
	public $conn;
	
	public function __construct($args)
	{
	  if(isset($args) && !empty($args))
	  {
		  if(is_array($args))
		  {
			  $arg=implode(",",$args);
			  $this->select = "SELECT $arg FROM ".$this->dbname;  
			  
		  }else
		  {
			$this->select = "SELECT $args FROM ".$this->dbname; 
		  }	  
		  
	  }else
	  {	  
	  $this->select = "SELECT * FROM ".$this->dbname;
	  }
	  
	 
	}
	
	//join
	public function joinOn($dbname,$joinon)
	{
		$this->joinOn = new joinOn($dbname,$joinon);
		$this->joinOn->command=$this->select ." ".$this->dbname;
		$this->joinOn->conn = $this->conn;
		$this->joinOn->dbname = $this->dbname ."," . $dbname;
		return $this->joinOn;
	}
	
	
	
	public function where($col,$tanda,$val)
	{
		$this->where = new where($col,$tanda,$val);
		$this->where->command=$this->select ." ".$this->dbname." WHERE ";
		$this->where->conn = $this->conn;
		$this->where->dbname = $this->dbname;
		return $this->where;
	}
	
	
	public function orderby($cols=[],$urut="ASC")
	{
		$this->orderby = new orderby($cols,$urut);
		$this->orderby->command=$this->select ." ".$this->dbname;
		$this->orderby->conn = $this->conn;
		$this->orderby->dbname = $this->dbname;
		return $this->orderby;
	}
	
	public function groupby($cols=[])
	{
		$this->groupby = new groupby($cols);
		$this->groupby->command=$this->select ." ".$this->dbname;
		$this->groupby->conn = $this->conn;
		$this->groupby->dbname = $this->dbname;
		return $this->groupby;
	}
	
	public function limit($cols=[])
	{
		$this->limit = new limit($cols);
		$this->limit->command=$this->select ." ".$this->dbname;
		$this->limit->conn = $this->conn;
		$this->limit->dbname = $this->dbname;
		return $this->limit;
	}
	
	public function get($json=[])
	{
		$per= $this->select ." ".$this->dbname;
		//return $per;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
}


class where
{
	public $command;
	
	//public $andWhere;
	protected $newcommand;
	public $conn;
	public $dbname;
	
	public function __construct($col,$tanda,$val)
	{
		$this->newcommand = $col." ".$tanda." '".$val."'";
				
		//$this->update();
		
	}
	
	
	public function andWhere($col,$tanda,$val)
	{
		//$this->andWhere = new where($col,$tanda,$val);
		$this->newcommand = $this->newcommand ." AND ".$col." ".$tanda." '".$val."'";
		return $this;
	}
	
	public function orWhere($col,$tanda,$val)
	{
		//$this->andWhere = new where($col,$tanda,$val);
		$this->newcommand = $this->newcommand ." OR ".$col." ".$tanda." '".$val."'";
		return $this;
	}
	
	public function orderby($cols=[],$urut="ASC")
	{
		//$this->andWhere = new where($col,$tanda,$val);
		$rsl='';
		if(is_array($cols))
		{
			if(count($cols)> 0)
			{
				$rsl = " ORDER BY ".implode(',',$cols)." $urut";
			}
				
		}
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	
	public function groupby($cols=[])
	{
		//$this->andWhere = new where($col,$tanda,$val);
		$rsl='';
		if(is_array($cols))
		{
			if(count($cols)> 0)
			{
				$rsl = " GROUP BY ".implode(',',$cols);
			}
				
		}
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	public function limit($args=[])
	{
		$rsl='';
		if(is_array($args))
		{
		   if(count($args) == 2)
		   {
			  $rsl = " LIMIT ".$args[0].",".$args[1]; 
		   }else if(count($args) == 1)
		   {
			  $rsl = " LIMIT ".$args[0];  
		   }
		
		}
		
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	
	public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
	public function execute()
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new execute($this->conn,$per);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
}

class orderby
{
	public $command;
	
	//public $andWhere;
	protected $newcommand;
	public $conn;
	public $dbname;
	public function __construct($cols,$urut="ASC")
	{
		$rsl='';
		if(is_array($cols))
		{
			if(count($cols)> 0)
			{
				$rsl = " ORDER BY ".implode(',',$cols)." $urut";
			}
				
		}
		
		$this->newcommand = $rsl;
				
		//$this->update();
		
	}
	
	
	public function limit($args=[])
	{
		$rsl='';
		if(is_array($args))
		{
		   if(count($args) == 2)
		   {
			  $rsl = " LIMIT ".$args[0].",".$args[1]; 
		   }else if(count($args) == 1)
		   {
			  $rsl = " LIMIT ".$args[0];  
		   }
		
		}
		
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}



class groupby
{
	public $command;
	
	//public $andWhere;
	protected $newcommand;
	public $conn;
	public $dbname;
	public function __construct($cols)
	{
		$rsl='';
		if(is_array($cols))
		{
			if(count($cols)> 0)
			{
				$rsl = " GROUP BY ".implode(',',$cols);
			}
				
		}
		
		$this->newcommand = $rsl;
				
		//$this->update();
		
	}
	
	public function orderby($cols=[],$urut="ASC")
	{
		//$this->andWhere = new where($col,$tanda,$val);
		$rsl='';
		if(is_array($cols))
		{
			if(count($cols)> 0)
			{
				$rsl = " ORDER BY ".implode(',',$cols)." $urut";
			}
				
		}
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	public function limit($args=[])
	{
		$rsl='';
		if(is_array($args))
		{
		   if(count($args) == 2)
		   {
			  $rsl = " LIMIT ".$args[0].",".$args[1]; 
		   }else if(count($args) == 1)
		   {
			  $rsl = " LIMIT ".$args[0];  
		   }
		
		}
		
		$this->newcommand = $this->newcommand . $rsl;
		return $this;
	}
	
	public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
		
	}
}


class limit
{
	public $command;
	public $conn;
	//public $andWhere;
	protected $newcommand;
	public $dbname;
	
	public function __construct($args)
	{
		$rsl='';
		if(is_array($args))
		{
		   if(count($args) == 2)
		   {
			  $rsl = " LIMIT ".$args[0].",".$args[1]; 
		   }else if(count($args) == 1)
		   {
			  $rsl = " LIMIT ".$args[0];  
		   }
		
		}
		
		$this->newcommand = $rsl;
				
		//$this->update();
		
	}

   public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;		
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
}


class joinOn
{
	public $command;
	
	//public $andWhere;
	protected $newcommand;
	public $conn;
	public $dbname;
	
	public function __construct($dbname,$joinon)
	{
		$this->newcommand = " JOIN " .$dbname ." ON ".$joinon;
		
	}
	
	public function joinOn($dbname,$joinon)
	{
		$this->newcommand = $this->newcommand . " JOIN " .$dbname ." ON ".$joinon;
		return $this;
	}
	
	public function where($col,$tanda,$val)
	{
		$this->where = new where($col,$tanda,$val);
		$this->where->command=$this->command . $this->newcommand ." WHERE ";
		$this->where->conn = $this->conn;
		$this->where->dbname = $this->dbname;
		return $this->where;
	}
	
	public function get($json=[])
	{
		//return $this->command . $this->newcommand;
		$per= $this->command . $this->newcommand;
		$obj = new get($this->conn,$per,$json);
		$obj->dbname = $this->dbname;
		return $obj->run();
	}
	
	
	
	
}


class get
{
	public $per;
	public $conn;
	public $json;
	public $dbname;
	public function __construct($conn,$per,$json=[])
	{
		$this->per = $per;
		$this->conn = $conn;
		$this->json =$json;
		//echo $per;
	}
	
	public function run()
	{
		$arr=[];
		if($hsl=mysqli_query($this->conn,$this->per))
		{
			$cols=$this->getCols();
			if(mysqli_num_rows($hsl) > 0)
			{
				while($bar=mysqli_fetch_array($hsl))
				{
					if(is_array($this->json) && count($this->json) > 0)
					{
						
							if(count($this->json) > 0)
							{
								foreach($this->json['col'] as $key=>$dat)
								{
									
									if(in_array($dat,$cols))
										{
											$j=json_decode($bar[$dat],true);
											$bar[$dat] = $j[$this->json['val'][$key]] ;
											//$arr[]=$bar;
										}
									
									
								}
								
											
							
							
						   }
						  
						 $arr[]=$bar; 
						  
						}else
						{	
							$arr[]=$bar;
						}
				}
			}
		}
		
		return $arr;
	}
	
	public function getCols()
	{
	     $cols=[];
		$arr=explode(",",$this->dbname);
		//echo "<br>".$this->dbname;
		if(count($arr) > 0)
		{
			
			foreach($arr as $ar)
			{
				$db=explode(" ",$ar);
				//$this->dbname = $db[0];
				
			   $hsl=mysqli_query($this->conn,"SHOW COLUMNS FROM ".$db[0]);

				while($bar=mysqli_fetch_array($hsl))
				{
					$cols[]= $bar['Field'];
				}
			
			}
			
        }else
		{
			$db=explode(" ",$this->dbname);
			//$this->dbname = $db[0];
			$hsl=mysqli_query($this->conn,"SHOW COLUMNS FROM ".$db[0]);
			while($bar=mysqli_fetch_array($hsl))
			{
				$cols[]= $bar['Field'];
			}
			
		}	
		
		//print_r($cols);
		return $cols;
	}
	
}


class execute
{
	protected $per;
	public $conn;
	public $dbname;
	public function __construct($conn,$per)
	{
		$this->per = $per;
		$this->conn = $conn;
	}
	
	public function run()
	{
		$arr=false;
		if($hsl=mysqli_query($this->conn,$this->per))
		{
			$arr=true;
		}
		
		return $arr;
	}
	
}



?>