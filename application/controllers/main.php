<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    // Registration
    public function register()
    {
        $this->load->view('newreg');
    }

	public function reg()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fname","fname",'required');
        $this->form_validation->set_rules("lname","lname",'required');
        $this->form_validation->set_rules("uname","uname",'required');
        $this->form_validation->set_rules("mobile","mobile",'required');
        $this->form_validation->set_rules("email","email",'required');
        $this->form_validation->set_rules("password","password",'required');
        if($this->form_validation->run())
        {
        $this->load->model('mainmodel');
        $pass=$this->input->post("password");
        $encpass=$this->mainmodel->encpswd($pass);
        $a=array("fname"=>$this->input->post("fname"),
                "lname"=>$this->input->post("lname"),
                "uname"=>$this->input->post("uname"),
                "mobile"=>$this->input->post("mobile"));
       $b=array( "email"=>$this->input->post("email"),
                "password"=>$encpass,
                "usertype"=>'1');
        $this->mainmodel->inreg($a,$b);    
        redirect(base_url().'main/loginform'); 
        }
    }    

     // Login 
   public function loginform()
    {
        $this->load->view('logform');
    }
     public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("email","email",'required');
        $this->form_validation->set_rules("password","password",'required');
            if($this->form_validation->run())
            {
                $this->load->model('mainmodel');
                $email=$this->input->post("email");
                $pass=$this->input->post("password");
                $rslt=$this->mainmodel->select($email,$pass);
                if($rslt)
                {
                    $id=$this->mainmodel->getuserid($email);
                    $user=$this->mainmodel->getuser($id);
                 $this->load->library(array('session'));
                $this->session->set_userdata(array('id'=>(int)$user->id,'status'=>$user->status,'usertype'=>$user->usertype));
                    if($_SESSION['status']=='1'&& $_SESSION['usertype']=='0' )
                    {
                                redirect(base_url().'main/view');
                    }
                    elseif($_SESSION['status']=='1'&& $_SESSION['usertype']=='1' )
                    {
                                redirect(base_url().'main/logform');
                    }
                    else
                    {
                        echo "waiting for approval";
                    }
                }
                else
                {
                 echo "invalid user";
                }
            }
else{
    redirect('main/logform','refresh');
    }
}

     // View User Details
     public function view()
    {
        $this->load->model('mainmodel');
        $data['n']=$this->mainmodel->view();
        $this->load->view('view',$data);
    }   

     // Approve /Reject
    public function approve()
    {
        $this->load->model('mainmodel');
        
        $id=$this->uri->segment(3);
        $this->mainmodel->approve($id);
        redirect('main/view','refresh');
    }   
    public function reject()
    {
        $this->load->model('mainmodel');
        
        $id=$this->uri->segment(3);
        $this->mainmodel->reject($id);
        redirect('main/view','refresh');
    }   

 }