<?php
/**
* Short desc
* 
* <p>This file is used as controller to control member page contents.</p>
* 
* @author Shahrukh Shaikh
*/  
defined('BASEPATH') OR exit('No direct script access allowed');
class ManagemembersController extends CI_Controller {
   public function __construct() {
          parent::__construct();
          $this->load->model('managemembersmodel');
          $this->load->library(array('form_validation','session'));
          $this->load->helper(array('url','html','form'));
		  $this->result='';
   }
   public function index() {
			$memberData = $this->managemembersmodel->getMemberDataM();
			if(!empty($memberData)):
			  foreach($memberData as $memkey => $memvalue):
				$this->displayParentChildrenMember($memvalue);
			  endforeach;
			  if($this->result != ''):
				  $data['memberData'] = $this->result;
			  else:
				   $data = array();
			  endif;
			else:
				   $data = array();
			endif;
			$this->load->view('managemembers/index',$data);
			$this->load->view('managemembers/script');
	 }
	/**
	* Defines displayParentChildrenMember, called from index fucntion/displayParentChildrenMember function file
	*
	* It is recursive function which get all members data from database
	*/
	public function displayParentChildrenMember($parentRow) {
		$pid = $parentRow['id'];
		$this->result .= "<li id='l-$pid'>".$parentRow['name'];
		$childMemberData = $this->managemembersmodel->getMemberDataM($parentRow['id']);
		if (!empty($childMemberData)):
			$this->result .= "<ul id='u-$pid'>";
			foreach($childMemberData as $cmemkey => $cmemvalue):
				$this->displayParentChildrenMember($cmemvalue);
			endforeach;
			$this->result .= '</ul>';
		endif;
		$this->result .= '</li>';
		return $this->result;
	}
	/**
	* Defines showAddMemberForm, called from managemembers/script.php file
	*
	* It load view of add memeber form
	*/
	public function showAddMemberForm()
	{
		try {
				$memberData = $this->managemembersmodel->getMemberAllDataM();
				$data['memberData'] = $memberData;
				$this->load->view('managemembers/addmember',$data);
		} catch(Exception $e) {
		   echo '<h1>Application error:</h1>';
		}
	}
	/**
	* Defines postAddMembersFormData, called from managemembers/script.php file
	*
	* It insert member information into database.
	*/
     public function postAddMembersFormData()
	 {
		$memparentid = isset($_POST['memparentid']) ? trim($_POST['memparentid']) : NULL;
		$memname = isset($_POST['memname']) ? trim($_POST['memname']) : NULL;
	    $memberRes = $this->managemembersmodel->checkMemberExists($memname,$memparentid);
		if($memberRes != 0):
		    $data['error'] = 2;
            $data['msg'] = "This Member already exists";
		    echo json_encode($data);
		    return;
		endif;
		try {
				if($memparentid != 0):
					$memberData = $this->managemembersmodel->getMemberDataM($memparentid);
					if(!empty($memberData)):
						$data['flag'] = 1;
					else:
						$data['flag'] = 2;
					endif;
				else:
					$data['flag'] = 0;
				endif;
                $this->managemembersmodel->setMemparentid($memparentid);
			  	$this->managemembersmodel->setMemname($memname);
			  	$res = $this->managemembersmodel->postAddMembersFormDataM();
				$data['pid'] = $memparentid;
				$data['cid'] = $res;
				$data['pname'] = $memname;
			  	if($res):
			     	$data['error'] = 1;
                    $data['msg'] = "Member Added Successfully";
			 	else:
			     	$data['error'] = 0;
			 	  	$data['msg'] = "Error While Adding Member";
			  	endif;
				echo json_encode($data);
		} catch (Exception $e) {
		 		echo '<h1>Application error:</h1>' . $e->getMessage();
		}
	}
}
?>
