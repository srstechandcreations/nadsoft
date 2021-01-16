<?php
/**
* Short desc
* 
* <p>This file is used as model to control member page contents.</p>
* 
* @author Shahrukh Shaikh
*/ 
class ManagemembersModel extends CI_Model {
    private $_memparentid;
    private $_memname;
	 
	public function setMemparentid($memparentid)
	{
		$this->_memparentid = $memparentid;
	}
	
	public function setMemname($memname)
	{
		$this->_memname = $memname;
	}
	
	/**
	* Defines getMemberDataM called from index function or getMemberData function
	* It fetches Member information from database.
	*/
	public function getMemberDataM($parent_id = 0)
   {
        $finalarray = array();
		$query = $this->db->query("SELECT * FROM  members WHERE parent_id = $parent_id");
		$memberData = $query->result_array();
		if (empty($memberData))
		{
			return false;
		} else {
			return $memberData;
		}
    }
	/**
	* Defines getMemberAllDataM called from showAddMemberForm function
	* It fetches all Member information from database.
	*/
	public function getMemberAllDataM()
   {
        $finalarray = array();
		$query = $this->db->query("SELECT * FROM  members");
		$memberData = $query->result_array();
		if (empty($memberData))
		{
			return false;
		} else {
			return $memberData;
		}
    }
	/**
	* Defines postAddMembersFormDataM called from managememberscontroller/postAddMembersFormData() function
	*
	* It insert memeber into database.
	*/
	public function postAddMembersFormDataM()
	{
        $curTime = date("Y-m-d h:i:s");
		$data = array(
				'name' => $this->_memname,
				'parent_id' => $this->_memparentid,
				'created_date' => $curTime
		);
		$res = $this->db->insert('members', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	/**
	* Defines checkMemberExists() called from managememberscontroller/postAddMembersFormData().
	* It takes member name and parent id and check if member name is already registered or not and return result accordingly.
	*/
		public function checkMemberExists($memname,$memparentid) {
		$query = $this->db->query("SELECT name FROM members WHERE name ='$memname' AND parent_id = '$memparentid' ");
        $res = $query->row_array();
		if(empty($res)):
			return false;
		else:
		    return $res;
		endif;
	}
}
?>
