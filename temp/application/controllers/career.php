<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Career extends CI_Controller {

    /**
     * MAIN CMS CONTROLLER
     * ihmsMedia CMS
     * Roland Ihms
     */
    function Career()
    {
        parent::__construct();
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('career_model');
        //force_ssl();
    }



    function csv_download(){

        $csvFilePath = BASE_URL."assets/csv/csv_file.csv";

        $date = date("Ymdhisa");

        $download_file = 'career_applicants_'.$date.'.csv';

        $this->load->helper('download');
        $data = file_get_contents($csvFilePath);
        force_download($download_file, $data);
    }


    function app_csv_download($vid){

        $csvFilePath = BASE_URL."assets/csv/csv_file.csv";

        $date = date("Ymdhisa");

        $download_file = 'Applicant_Export_'.$vid.'_'.$date.'.csv';

        $this->load->helper('download');
        $data = file_get_contents($csvFilePath);
        force_download($download_file, $data);
    }



    function send_applicant_message() {

        $db2 = $this->career_model->connect_my_db();
        $app_files = $this->input->post('app_files');
        $vacancy = $this->input->post('vacancy');
        $message_body = $this->input->post('message_body', TRUE);

        if(!empty($app_files)) {

            foreach($app_files as $aid) {

                //GET USER DETAILS
                $query = $db2->query("SELECT B.email, C.CLIENT_NAME, C.CLIENT_SURNAME FROM vacancy_applicants AS A LEFT JOIN applicants AS B ON A.client_id = B.client_id LEFT JOIN u_client AS C ON A.client_id = C.ID WHERE A.va_id = '".$aid."'", FALSE);

                $row = $query->row();

                $body = 'Dear '.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'<br><br>'.$message_body;

                $senddata = array(
                    'name' => 'Careers',
                    'from_email' => 'noreply@my.na',
                    'email' => 'noreply@my.na',
                    'body' => $body,
                    'email_to' => $row->email,
                    'subject' => 'Message from My.na Career Portal - ' . $vacancy
                );

                $this->load->model('email_model');
                $this->email_model->send_enquiry($senddata);

            }

        }

    }



    //++++++++++++++++++++++++++
    //LOAD AUTOMATED MESSAGES
    //++++++++++++++++++++++++++
    public function messages()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/auto_messaging/messages');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD MESSAGE
    //++++++++++++++++++++++++++
    public function add_message()
    {

        if($this->session->userdata('admin_id')){

            $this->load->view('career/auto_messaging/add_message');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD MESSAGE DO
    //++++++++++++++++++++++++++
    public function add_message_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->add_message_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE MESSAGE
    //++++++++++++++++++++++++++
    public function update_message($mid)
    {

        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_message($mid);
            $this->load->view('career/auto_messaging/update_message', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE MESSAGE DO
    //++++++++++++++++++++++++++
    public function update_message_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->update_message_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE MESSAGE DO
    //++++++++++++++++++++++++++
    public function delete_message_do($mid)
    {
        $this->career_model->delete_message_do($mid);
    }



    //+++++++++++++++++++++++++++
    //ACTION MESSAGE BULK
    //++++++++++++++++++++++++++
    public function action_message_bulk($data)
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->action_message_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD MESSAGES
    //++++++++++++++++++++++++++
    public function reload_messages_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_messages();

        }else{

            $this->load->view('admin/login');

        }

    }


    function manage_messages($msg_id) {

        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_am_message($msg_id);

            $this->load->view('career/auto_messaging/manage_messages', $data);

        }else{

            $this->load->view('admin/login');

        }
    }


    //+++++++++++++++++++++++++++
    //UPDATE SMS DO
    //++++++++++++++++++++++++++
    public function update_sms_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_sms_do();

        }else{

            $this->load->view('admin/login');

        }
    }



    function remove_potentia_entries() {

        $this->career_model->remove_potentia_entries();

    }

    //++++++++++++++++++++++++++
    //LOAD MASTERFILES
    //++++++++++++++++++++++++++
    public function masterfiles($cid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_client($cid);
            $this->load->view('career/clients/masterfiles', $data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD MASTERFILES
    //++++++++++++++++++++++++++
    public function add_masterfiles()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_masterfiles();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD MASTERFILES
    //++++++++++++++++++++++++++
    public function reload_masterfiles($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_masterfiles($id);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD MASTER DIRECTORY DO
    //++++++++++++++++++++++++++

    public function add_master_dir_do($parent, $client)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_master_dir_do($parent, $client);

        }else{

            $this->load->view('admin/login');

        }
    }



    //++++++++++++++++++++++++++
    //LOAD PANELLISTS
    //++++++++++++++++++++++++++
    public function panellists()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/panellists');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE Panellist
    //++++++++++++++++++++++++++
    public function update_panellist($pid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_panellist($pid);
            $this->load->view('career/interview/update_panellist', $data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE PANELLIST DO
    //++++++++++++++++++++++++++
    public function update_panellist_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_panellist_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD PANELLIST
    //++++++++++++++++++++++++++
    public function add_panellist()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/add_panellist');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD PANELLIST DO
    //++++++++++++++++++++++++++
    public function add_panellist_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_panellist_do();

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //DELETE PANELLIST DO
    //++++++++++++++++++++++++++
    public function delete_panellist_do($pid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_panellist_do($pid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD PANELLISTS
    //++++++++++++++++++++++++++
    public function reload_panellist_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_panellists();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Panellist Bulk
    //++++++++++++++++++++++++++
    public function action_panellist_bulk($data)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_panellist_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //ADD JOB PANELLIST DO
    //++++++++++++++++++++++++++
    public function add_job_panellist_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_job_panellist_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //REMOVE JOB PANELLIST DO
    //++++++++++++++++++++++++++
    public function remove_job_panellist_do($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->remove_job_panellist_do($id);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD JOB PANELLISTS
    //++++++++++++++++++++++++++
    public function reload_job_panellists($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_job_panellists($id);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //LOAD JOB FILES
    //++++++++++++++++++++++++++
    public function job_files()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/job_files');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE JOB FILE
    //++++++++++++++++++++++++++
    public function update_job_file($jid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_job_file($jid);
            $this->load->view('career/interview/update_job_file', $data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE JOB FILE DO
    //++++++++++++++++++++++++++
    public function update_job_file_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_job_file_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD VACANCY
    //++++++++++++++++++++++++++
    public function add_job_file()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/add_job_file');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD JOB FILE DO
    //++++++++++++++++++++++++++
    public function add_job_file_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_job_file_do();

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //DELETE JOB FILE DO
    //++++++++++++++++++++++++++
    public function delete_job_file_do($jid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_job_file_do($jid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD JOB FILES
    //++++++++++++++++++++++++++
    public function reload_job_files_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_job_files();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Job Files Bulk
    //++++++++++++++++++++++++++
    public function action_job_files_bulk($data)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_job_files_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }







    //+++++++++++++++++++++++++++
    //RELOAD INTERVIEW QUESTIONS
    //++++++++++++++++++++++++++
    public function reload_interview_questions($cid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->interview_survey_questions($cid);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //LOAD INTERVIEW SURVEYS
    //++++++++++++++++++++++++++
    public function interview_survey()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/survey');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD INTERVIEW SURVEY
    //++++++++++++++++++++++++++
    public function add_interview_survey()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/interview/add_survey');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD INTERVIEW SURVEY DO
    //++++++++++++++++++++++++++
    public function add_interview_survey_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_interview_survey_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE INTERVIEW SURVEY
    //++++++++++++++++++++++++++
    public function update_interview_survey($sid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_interview_survey($sid);
            $this->load->view('career/interview/update_survey', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE INTERVIEW SURVEY DO
    //++++++++++++++++++++++++++
    public function update_interview_survey_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_interview_survey_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE INTERVIEW SURVEY DO
    //++++++++++++++++++++++++++
    public function delete_interview_survey_do($vid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_interview_survey_do($vid);

        }else{

            $this->load->view('admin/login');

        }

    }



    //SURVEY QUESTIONS
    function add_interview_survey_question_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_interview_survey_question_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //SURVEY QUESTIONS
    function interview_survey_questions($survey_id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->interview_survey_questions($survey_id);

        }else{

            $this->load->view('admin/login');

        }



    }

    //+++++++++++++++++++++++++++
    //DELETE INTERVIEW SURVEY QUESTION DO
    //++++++++++++++++++++++++++
    public function delete_interview_survey_question_do($vid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_interview_survey_question_do($vid);

        }else{

            $this->load->view('admin/login');

        }

    }




    function upload_potentia() {


        if($this->session->userdata('admin_id')){

            $this->career_model->upload_potentia();

        }else{

            $this->load->view('admin/login');

        }


    }


    function get_applicant_details($id) {

        if($this->session->userdata('admin_id')){


            $this->career_model->get_applicant_details($id);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //FILTER APPLICANTS
    //++++++++++++++++++++++++++

    public function filter_applicants()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->filter_applicants();

        }else{

            $this->load->view('admin/login');

        }
    }
	
	
    //+++++++++++++++++++++++++++
    //SORT APPLICANTS
    //++++++++++++++++++++++++++

    public function sort_applicant($id, $type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->sort_applicants($id, $type);

        }else{

            $this->load->view('admin/login');

        }
    }	


    //+++++++++++++++++++++++++++
    //POST APPLICANT REPLY
    //++++++++++++++++++++++++++
    public function post_app_reply()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->post_app_reply();

        }else{

            $this->load->view('admin/login');

        }


    }

    //+++++++++++++++++++++++++++
    //POST APPLICANT MESSAGE
    //++++++++++++++++++++++++++
    public function post_app_message()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->post_app_message();

        }else{

            $this->load->view('admin/login');

        }


    }


    //+++++++++++++++++++++++++++
    //RELOAD APPLICANTS ALL
    //++++++++++++++++++++++++++
    public function reload_applicants_filters_all()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->reload_applicants_filters_all();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD APPLICANTS ALL
    //++++++++++++++++++++++++++
    public function reload_applicants_all()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_applicants();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD APPLICANT DOCUMENTS
    //++++++++++++++++++++++++++
    public function reload_applicant_documents($cid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_applicant_docs($cid);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD APPLICANT MESSAGES
    //++++++++++++++++++++++++++
    public function reload_applicant_messages($id)
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->get_app_messages($id);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD CLIENT TOKEN DO
    //++++++++++++++++++++++++++
    public function add_client_token_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->add_client_token_do();

        }else{

            $this->load->view('admin/login');

        }


    }

    //+++++++++++++++++++++++++++
    //LOAD CLIENTS
    //++++++++++++++++++++++++++
    public function clients()
    {

        if($this->session->userdata('admin_id')){

            $this->load->view('career/clients/clients');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD CLIENT
    //++++++++++++++++++++++++++
    public function add_client()
    {

        if($this->session->userdata('admin_id')){

            $this->load->view('career/clients/add_client');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD CLIENT DO
    //++++++++++++++++++++++++++
    public function add_client_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->add_client_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE CLIENT
    //++++++++++++++++++++++++++
    public function update_client($cid)
    {

        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_client($cid);
            $this->load->view('career/clients/update_client', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE CLIENT DO
    //++++++++++++++++++++++++++
    public function update_client_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->update_client_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE CLIENT DO
    //++++++++++++++++++++++++++
    public function delete_client_do($cid)
    {
        $this->career_model->delete_client_do($cid);
    }

    //+++++++++++++++++++++++++++
    //DELETE CLIENT TOKEN DO
    //++++++++++++++++++++++++++
    public function delete_client_token_do($tid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_client_token_do($tid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Client Bulk
    //++++++++++++++++++++++++++
    public function action_client_bulk($data)
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->action_client_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD CLIENTS
    //++++++++++++++++++++++++++
    public function reload_clients_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_clients();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD CLIENT TOKENS
    //++++++++++++++++++++++++++
    public function reload_client_tokens($cid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_client_tokens($cid);

        }else{

            $this->load->view('admin/login');

        }

    }





    //+++++++++++++++++++++++++++
    //LOAD DEPARTMENTS
    //++++++++++++++++++++++++++
    public function departments()
    {

        if($this->session->userdata('admin_id')){

            $this->load->view('career/departments/departments');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD DEPARTMENT
    //++++++++++++++++++++++++++
    public function add_department()
    {

        if($this->session->userdata('admin_id')){

            $this->load->view('career/departments/add_department');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD DEPARTMENT DO
    //++++++++++++++++++++++++++
    public function add_department_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->add_department_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE DEPARTMENT
    //++++++++++++++++++++++++++
    public function update_department($did)
    {

        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_department($did);
            $this->load->view('career/departments/update_department', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE DEPARTMENT DO
    //++++++++++++++++++++++++++
    public function update_department_do()
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->update_department_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE DEPARTMENT DO
    //++++++++++++++++++++++++++
    public function delete_department_do($cid)
    {
        $this->career_model->delete_department_do($cid);
    }



    //+++++++++++++++++++++++++++
    //Action Department Bulk
    //++++++++++++++++++++++++++
    public function action_department_bulk($data)
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->action_department_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD DEPARTMENTS
    //++++++++++++++++++++++++++
    public function reload_departments_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_departments();

        }else{

            $this->load->view('admin/login');

        }

    }





    //+++++++++++++++++++++++++++
    //LOAD DASHBOARD
    //++++++++++++++++++++++++++
    public function index()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/dashboard');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //LOAD APPLICANTS
    //++++++++++++++++++++++++++
    public function applicants()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/applicants/applicants');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD APPLICANT
    //++++++++++++++++++++++++++
    public function add_applicant()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/applicants/add_applicant');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE APPLICANT
    //++++++++++++++++++++++++++
    public function update_applicant($aid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_applicant($aid);
            $this->load->view('career/applicants/update_applicant', $data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //GET APPLICANT DUMP
    //++++++++++++++++++++++++++
    function get_applicant_dump($id)
    {
        $this->career_model->get_applicant_dump($id);
    }


    //+++++++++++++++++++++++++++
    //ADD APPLICANT DO
    //+++++++++++++++++++++++++++
    public function add_applicant_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_applicant_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE APPLICANT DO
    //++++++++++++++++++++++++++
    public function delete_applicant_do($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_applicant_do($id);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Applicants Bulk
    //++++++++++++++++++++++++++
    public function action_applicants_bulk($data)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_applicants_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //LOAD (INDUSTRY CATS
    //++++++++++++++++++++++++++
    public function industry_categories()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/industry_categories');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD INDUSTRY CATS
    //++++++++++++++++++++++++++
    public function add_industry_cat_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_industry_category_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //DELETE INDUSTRY CAT DO
    //++++++++++++++++++++++++++
    public function delete_industry_cat_do($cid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_industry_cat_do($cid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD INDUSTRY CATS
    //++++++++++++++++++++++++++
    public function reload_industry_cat_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_industry_categories();

        }else{

            $this->load->view('admin/login');

        }

    }




    //+++++++++++++++++++++++++++
    //LOAD DISCIPLINES
    //++++++++++++++++++++++++++
    public function disciplines()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/disciplines');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD DISCIPLINE
    //++++++++++++++++++++++++++
    public function add_discipline_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_discipline_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //DELETE DISCIPLINE DO
    //++++++++++++++++++++++++++
    public function delete_discipline_do($did)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_discipline_do($did);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD DISCIPLINES
    //++++++++++++++++++++++++++
    public function reload_disciplines_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_disciplines();

        }else{

            $this->load->view('admin/login');

        }

    }




    //+++++++++++++++++++++++++++
    //LOAD LOCATIONS
    //++++++++++++++++++++++++++
    public function locations()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/locations');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD LOCATIONS
    //++++++++++++++++++++++++++
    public function add_location_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_location_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //DELETE LOCATION DO
    //++++++++++++++++++++++++++
    public function delete_location_do($lid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_location_do($lid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD LOCATIONS
    //++++++++++++++++++++++++++
    public function reload_locations_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_locations();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //Action Location Bulk
    //++++++++++++++++++++++++++
    public function action_location_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_location_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }




    //+++++++++++++++++++++++++++
    //LOAD MANAGMENT LEVEL
    //++++++++++++++++++++++++++
    public function management()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/management');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD MANAGEMENT LEVEL
    //++++++++++++++++++++++++++
    public function add_management_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_management_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //DELETE MANAGEMENT DO
    //++++++++++++++++++++++++++
    public function delete_management_do($mid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_management_do($mid);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD MANAGEMENT LEVEL
    //++++++++++++++++++++++++++
    public function reload_management_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_management();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Management Bulk
    //++++++++++++++++++++++++++
    public function action_management_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_management_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //Action Long List Bulk
    //++++++++++++++++++++++++++
    public function action_long_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_long_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Short List Bulk
    //++++++++++++++++++++++++++
    public function action_short_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_short_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }




    //+++++++++++++++++++++++++++
    //LOAD MRS
    //++++++++++++++++++++++++++
    public function minimum_requirements()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/minimum_requirements');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD MR
    //++++++++++++++++++++++++++
    public function add_mr_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_mr_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //DELETE MR DO
    //++++++++++++++++++++++++++
    public function delete_mr_do($did)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_mr_do($did);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //Action MR Bulk
    //++++++++++++++++++++++++++
    public function action_mr_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_mr_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD MRS
    //++++++++++++++++++++++++++
    public function reload_mr_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_mr();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //LOAD VACANCIES
    //++++++++++++++++++++++++++
    public function vacancies()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/vacancies');

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //ADD VACANCY
    //++++++++++++++++++++++++++
    public function add_vacancy()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/add_vacancy');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD VACANCY DO
    //++++++++++++++++++++++++++
    public function add_vacancy_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_vacancy_do();

        }else{

            $this->load->view('admin/login');

        }

    }
	

    //+++++++++++++++++++++++++++
    //VACANCY APPLICANTS
    //++++++++++++++++++++++++++
    public function vacancy_applicants($vid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_vacancy($vid);
			
            $this->load->view('career/vacancies/vacancy_applicants', $data);

        }else{

            $this->load->view('admin/login');

        }

    }
	

    //+++++++++++++++++++++++++++
    //UPDATE VACANCY
    //++++++++++++++++++++++++++
    public function update_vacancy($vid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_vacancy($vid);
            $this->load->view('career/vacancies/update_vacancy', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE VACANCY DO
    //++++++++++++++++++++++++++
    public function update_vacancy_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_vacancy_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE VACANCY DO
    //++++++++++++++++++++++++++
    public function delete_vacancy_do($vid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_vacancy_do($vid);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //LOAD VACANCY SURVEYS
    //++++++++++++++++++++++++++
    public function vacancy_survey()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/survey');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD VACANCY SURVEY
    //++++++++++++++++++++++++++
    public function add_vacancy_survey()
    {
        if($this->session->userdata('admin_id')){

            $this->load->view('career/vacancies/add_survey');

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD VACANCY SURVEY DO
    //++++++++++++++++++++++++++
    public function add_vacancy_survey_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_vacancy_survey_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE VACANCY
    //++++++++++++++++++++++++++
    public function update_vacancy_survey($sid)
    {
        if($this->session->userdata('admin_id')){

            $data = $this->career_model->get_vacancy_survey($sid);
            $this->load->view('career/vacancies/update_survey', $data);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE VACANCY SURVEY DO
    //++++++++++++++++++++++++++
    public function update_vacancy_survey_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_vacancy_survey_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE VACANCY SURVEY DO
    //++++++++++++++++++++++++++
    public function delete_vacancy_survey_do($vid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_vacancy_survey_do($vid);

        }else{

            $this->load->view('admin/login');

        }

    }



    //SURVEY QUESTIONS
    function add_vacancy_mr_question_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_vacancy_mr_question_do();

        }else{

            $this->load->view('admin/login');

        }

    }


    //SURVEY QUESTIONS
    function vacancy_survey_questions($survey_id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->vacancy_survey_questions($survey_id);

        }else{

            $this->load->view('admin/login');

        }



    }

    //+++++++++++++++++++++++++++
    //DELETE VACANCY MR QUESTION DODO
    //++++++++++++++++++++++++++
    public function delete_vacancy_mr_question_do($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_vacancy_mr_question_do($id);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function add_featured_image()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_featured_image();

        }else{

            $this->load->view('admin/login');

        }


    }


    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function remove_featured_image($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->remove_featured_image($id);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function add_vacancy_docs()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->add_vacancy_docs();

        }else{

            $this->load->view('admin/login');

        }


    }


    //+++++++++++++++++++++++++++
    //DOWNLOAD VACANCY DOC
    //++++++++++++++++++++++++++

    public function download_vacancy_document($did)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->download_vacancy_document($did);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //DELETE VACANCY DOCUMENT DO
    //++++++++++++++++++++++++++
    public function delete_vacancy_document_do($vid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->delete_vacancy_document_do($vid);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD VACANCIES
    //++++++++++++++++++++++++++
    public function reload_vacancies_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_vacancies();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD VACANCIY QUESTIONS
    //++++++++++++++++++++++++++
    public function reload_vacancy_questions($id)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->vacancy_mr_questions($id);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //UPDATE VACANCY MR QUESTIONS
    //++++++++++++++++++++++++++
    public function update_vacancy_mr_question($qid)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_vacancy_mr_question($qid);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE VACANCY MR QUESTIONS DO
    //++++++++++++++++++++++++++
    public function update_vacancy_mr_question_do()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->update_vacancy_mr_question_do();

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //RELOAD SURVEYS
    //++++++++++++++++++++++++++
    public function reload_vacancy_surveys_all()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_all_vacancy_surveys();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //RELOAD VACANCY DOCUMENTS
    //++++++++++++++++++++++++++
    public function reload_vacancy_documents($vid, $level)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->get_vacancy_docs($vid, $level);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //Action Vacancy Bulk
    //++++++++++++++++++++++++++
    public function action_vacancy_survey_bulk($data)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_vacancy_survey_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //Action Vacancy Bulk
    //++++++++++++++++++++++++++
    public function action_vacancy_bulk($data)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_vacancy_bulk($data);

        }else{

            $this->load->view('admin/login');

        }

    }

    //+++++++++++++++++++++++++++
    //Action Vacancy Documents Bulk
    //++++++++++++++++++++++++++
    public function action_vacancy_docs_bulk()
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_vacancy_docs_bulk();

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Vacancy MR Bulk
    //++++++++++++++++++++++++++
    public function action_vacancy_mr_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_vacancy_mr_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }



    //+++++++++++++++++++++++++++
    //Action Career Categories Bulk
    //++++++++++++++++++++++++++
    public function action_career_cat_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_career_cat_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //Action Discipline Bulk
    //++++++++++++++++++++++++++
    public function action_discipline_bulk($type)
    {
        if($this->session->userdata('admin_id')){

            $this->career_model->action_discipline_bulk($type);

        }else{

            $this->load->view('admin/login');

        }

    }


    //+++++++++++++++++++++++++++
    //update QUESTION sequence
    //++++++++++++++++++++++++++

    public function update_vacancy_mr_sequence($id , $sequence)
    {

        if($this->session->userdata('admin_id')){

            $this->career_model->update_vacancy_mr_sequence($id , $sequence);

        }else{

            $this->load->view('admin/login');

        }



    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //CLEAN BUSINESS NAME
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //setlocale(LC_ALL, 'en_US.UTF8');
    function clean_url_str($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //CLEAN BUSINESS URL SLUG
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //setlocale(LC_ALL, 'en_US.UTF8');
    function clean_slug_str($str, $replace=array(), $delimiter='-' , $type) {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        //test Databse
        //$this->db->where('bus_id', $this->session->userdata('bus_id'));
        $this->db->where('slug', $clean);
        $res = $this->db->get($type);

        if($res->result()){

            $clean = $clean .'-'.rand(0,99);
            return $clean;

        }else{

            return $clean;
        }


    }


}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */