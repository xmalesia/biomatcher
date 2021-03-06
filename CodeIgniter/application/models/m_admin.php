<?php
class M_admin extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
     * login function for admin
     * 
     * @param string $username = username used for login
     * @return array userdata = array(id,username,email,password,name,type)
     * */
    function login_admin($username)
    {
        $query = $this->db->query("SELECT * FROM user where username='$username' and type='admin' limit 1");

        $data=$query->result();
        $hasil['sukses']=$query->num_rows();
        
        if ($query->num_rows() >=1)
        {
            $hasil['id']=$data[0]->id;
            $hasil['username']=$data[0]->username;
            $hasil['email']=$data[0]->email;
			$hasil['password']=$data[0]->password;
            $hasil['name']=$data[0]->name;
            $hasil['type']=$data[0]->type;
        }
        return $hasil;
    }
    
    /**
     * check password match in database
     * 
     * @param integer $id_user = id of user
     * @param string $key = encrypted password
     * 
     * @return boolean TRUE/FALSE
     * */
    function check_password($id_user,$key){
        $query = $this->db->query("SELECT * FROM user where id = '".$id_user."' and password ='".$key."' ");
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * check username exist in database
     * 
     * @param integer $id_user = id of user
     * @param string $key = username of user
     * 
     * @return boolean TRUE/FALSE
     * */
    function check_username($id_user,$key){
        $query = $this->db->query("SELECT * FROM user where id = '".$id_user."' and username ='".$key."' ");
        if ($query->num_rows() > 0){
            return TRUE;
        }
        else{
            $query2 = $this->db->query("SELECT * FROM user where username ='".$key."' ");
            if ($query2->num_rows() > 0){
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
    }
    
    /**
     * update admin userdata
     * 
     * @param integer $id_user = id of user
     * @param string $name = name of user
     * @param string $username = username of user
     * @param string $email = user's email
     * 
     * @return json array = array(result)
     * */
    function profile_admin($id_user,$name,$username,$email){
        $data = array(
               'name' => $name,
               'username' => $username,
               'email' => $email
            );
        
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);    
        
        $data_admin = $this->db->get_where('user', array('id' => $id_user));
        $get_admin = $data_admin->result();  
        $this->session->set_userdata(array('name' =>$get_admin[0]->name,'username' => $get_admin[0]->username, 'id_user' => $get_admin[0]->id, 'email' => $get_admin[0]->email, 'type' => $get_admin[0]->type));
        echo json_encode(array('result' => 'Success')); 
    }
    
    /**
     * update admin userdata
     * 
     * @param integer $id_user = id of user
     * @param string $name = name of user
     * @param string $username = username of user
     * @param string $email = user's email
     * 
     * @return json array = array(result)
     * */
    function pass_admin($id_user,$new_pass){
        $data = array(
               'password' => $new_pass
            );
        
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        echo json_encode(array('result' => 'Success')); 
    }
    
    /**
     * check user type
     * 
     * @param integer $id_user = id of user
     * 
     * @return string user type. user type
     * */
    function user_type($id){
        $this->db->select('type');
        $user = $this->db->get_where('user', array('id' => $id));
        $user_type = $user->result();
        if(!empty($user_type)){
            foreach ($user_type as $userData){
                $return_type = $userData->type;
            }
            return $return_type;
        }
    }
    
    /**
     * get project per page
     * 
     * @param integer $perPage = number of project's data to return per page
     * @param integer $uri = start index of project's data to return
     * 
     * @return array $result = list project's data
     * */
    function list_project($perPage,$uri){
        $this->db->select('project.name as project_name,user.name as user_name,project.id as project_id,project.userID as project_userID');
        $this->db->order_by('project.id','ASC');
        $this->db->join('user', 'project.userID = user.id','left');
        $query = $this->db->get('project', $perPage, $uri);
        return $query->result();
    }
    
    /**
     * get user per page
     * 
     * @param integer $perPage = number of users's data to return per page
     * @param integer $uri = start index of users's data to return
     * 
     * @return array $result = list users's data
     * */
    function list_user($perPage,$uri){
        $query = $this->db->get('user', $perPage, $uri);
        return $query->result();
    }
    
    /**
     * get site per page with it's owner's data
     * 
     * @param integer $perPage = number of sites's data to return per page
     * @param integer $uri = start index of sites's data to return
     * 
     * @return array $result = list sites's data
     * */
    function list_website($perPage,$uri){
        $this->db->order_by('site.id','ASC');
        $this->db->join('user', 'site.userID = user.id','left');
        $query = $this->db->get('site', $perPage, $uri);
        return $query->result();
    }
    
    /**
     * get image per page by project id
     * 
     * @param integer $perPage = number of images's data to return per page
     * @param integer $uri = start index of images's data to return
     * 
     * @return array $result = list images's data
     * */
    function list_image($perPage,$uri){
        $project_id = $this->uri->segment(4, 0);
        $this->db->where('projectID',$project_id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get('image', $perPage, $uri);
        return $query->result();
    }
    
    /**
     * get list project of a user with supplier type
     * 
     * @param integer $user_id = id of user
     * 
     * @return array $result = list project's data
     * */
    function project_supplier($user_id){
        $this->db->select('project.id as project_id, project.name as project_name, project.qcSet as project_qcSet, user.username as username, user.name as name, user.type as type, user.email as email');
        $this->db->join('project', 'project.userID = user.id');
        $this->db->where('user.id',$user_id);
        $query = $this->db->get('user');
        return $query->result();
    }
    
    /**
     * get list site of a user with consumer type
     * 
     * @param integer $user_id = id of user
     * 
     * @return array $result = list sites's data
     * */
    function project_consumer($user_id){
        $this->db->select('site.id as site_id, site.url as site_url, site.url_activated as url_activated, user.username as username, user.name as name, user.type as type, user.email as email');
        $this->db->join('site', 'site.userID = user.id');
        $this->db->where('user.id',$user_id);
        $query = $this->db->get('user');
        return $query->result();
    }
    
    /**
     * get a project's data by project id
     * 
     * @param integer $project_id = id of project
     * 
     * @return array $result = project's data
     * */
    function project_data($project_id){
        $query=$this->db->query("SELECT * FROM project where id='$project_id'");
        return $query->result();            
    }
    
    /**
     * get a user's data by user id
     * 
     * @param integer $user_id = id of user
     * 
     * @return array $result = user's data
     * */
    function user_data($user_id){
        $query=$this->db->query("SELECT * FROM user where id='$user_id'");
        return $query->result();            
    }
    
    /**
     * get list images by project id
     * 
     * @return array $result = list images's data
     * */
    function get_csv(){
        $this->load->dbutil();
        $project_id = $this->uri->segment(4, 0);
        $query = $this->db->query("SELECT nameOri,label FROM image where projectID='$project_id' order by id DESC");
        return $query->result();  
        $delimiter = ",";
        $newline = "\r\n";

      // echo $this->dbutil->csv_from_result($query, $delimiter, $newline);
    }
    
    /**
     * get a matches data by site id
     * 
     * @param integer $siteID = site id
     * 
     * @return array $result = matches's data
     * */
    function matches_data($siteID){
        $this->db->select('*');
        $matches = $this->db->get_where('match', array('siteID' => $siteID));
        $matches_data = $matches->result();
        if(!empty($matches_data)){
            return $matches_data;
        }
    }
    
    /**
     * get image's data with it's project's data by image id in QCSet project
     * 
     * @param integer $imageID = image id
     * 
     * @return array $result = image's data
     * */
    function image_data($imageID){
        $this->db->select('*');
        $this->db->from('image');
        $this->db->join('project', 'image.projectID=project.id');
        $this->db->limit(1);
        $this->db->where(array('image.id' => $imageID, 'qcSet' => 'yes'));
        $image_query = $this->db->get();
        $image_data = $image_query->result_array();
        if(!empty($image_data)){
            return $image_data;
        }
    }
    
    /**
     * isQC
     * check a project is Quality Control Set or not
     * @param projectID
     **/
    function isQC($projectID){
        $this->db->select('qcSet');
        $query = $this->db->get_where('project', array('id' => $projectID));
        $dataQC = $query->result(); 
        foreach ($dataQC as $data){
            if($data->qcSet == 'yes'){
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * get matches data by project id
     * 
     * @param projectID
     * 
     * @return array query result
     **/
    function match_images($projectID){
        $query = $this->db->query("SELECT m.imageA,m.imageB,projectID, CONCAT (GREATEST(m.imageA,m.imageB),',',LEAST(m.imageA,m.imageB)) as pair_id,
                    sum(case when m.same = 'yes' then 1 else 0 end) as same_match,
                    sum(case when m.same = 'no' then 1 else 0 end) as diff_match,
                    COUNT(*) as match_sum
                    FROM `match` m
                    JOIN `image` i ON m.`imageA` = i.`id` WHERE i.`projectID` = '$projectID'
                    GROUP BY pair_id");
        $stat=$query->result();
        
        return $stat;
    }
    
    /**
     * get original name of an image by image id
     * 
     * @param $id = image id
     * 
     * @return array original name of an image
     **/
    function get_name_image($id){
        $this->db->select('nameOri');
        $this->db->where('id',$id);
        $query = $this->db->get('image');
        return $query->result();
    }
    
    /**
     * count matches data with same/different attribute
     * 
     * @param $imageA = image id
     * @param $imageB = image id
     * @param $same = attribute of match (same/different)
     * 
     * @return integer sum of matches data
     **/
    function same($imageA, $imageB, $same){
        $where = array('imageA'=> $imageA, 'imageB' => $imageB, 'same' => $same);        
        $query = $this->db->get_where('match', $where);
        return $query->num_rows();
    }
    
    /**
     * count total matches data of an image
     * 
     * @param $imageA = image id
     * 
     * @return integer sum of matches data
     **/
    function total_matches($imageA){
        $this->db->where('imageA IN ('.implode(',',$imageA).')', NULL, FALSE);
        $query = $this->db->get('match');
        return $query->num_rows();
    }
    
    /**
     * get matches data of a project and convert it to csv file
     * 
     * @param $project_id = project id
     * @param $same = attribute of match (same/different)
     * @param $percent = yes/no. determined wether return percentage of matches data or not
     * 
     * @return file download
     **/
    function download_statistic($project_id,$same,$percent){
        $list_image_a = array();
        $list_image_a[] = "imageA/imageB";
        $list_image_b = array();
        //get all image with the same projectID
        $q_a = "SELECT id,nameOri from `image` where projectID = '".$project_id."' order by id";
        $get_image = $this->db->query($q_a)->result();
        for($i=0;$i<count($get_image);$i++){
            //divide into 2 list images
            $list_image_a[]=$get_image[$i]->nameOri;
            $list_image_b[]=$get_image[$i]->nameOri;
        }    
        
        $matching_image = array();
        //get count
        if($percent == 'no'){
            for($j=0;$j<count($get_image);$j++){
                for($i=0;$i<count($get_image);$i++){
                    $q_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$same."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung = $this->db->query($q_hitung)->result();
                    $matching_image[$get_image[$j]->nameOri][$get_image[$i]->nameOri] = $get_hitung[0]->hitung;
                }    
            }
        }
        //get percent count
        else if($percent == 'yes'){
            for($j=0;$j<count($get_image);$j++){
                for($i=0;$i<count($get_image);$i++){
                    if($same == 'yes'){
                        $comparison = 'no';
                    }
                    else if($same == 'no'){
                        $comparison = 'yes';
                    }
                    $q_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$same."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung = $this->db->query($q_hitung)->result();
                    $c_hitung = "SELECT count(*) as hitung from `match` where imageA = '".$get_image[$i]->id."' and same = '".$comparison."' and imageB ='".$get_image[$j]->id."'";
                    $get_hitung_comparison = $this->db->query($c_hitung)->result();
                    
                    $initial = $get_hitung[0]->hitung;
                    $comparative = $get_hitung_comparison[0]->hitung;
                    
                    if($initial == 0){
                        $percentage = 0;
                    }
                    else{
                        $percentage = round(($initial /($initial + $comparative))*100,2);
                    }
                    
                    
                    $matching_image[$get_image[$j]->nameOri][$get_image[$i]->nameOri] = $percentage.'%';
                }    
            }
        }
        
        ksort($matching_image);        
        
        //array format for csv result
        $array[] = $list_image_a;
        foreach($list_image_b as $key=>$val){    
            $ar_row = array();
            $ar_row[0]=$val;
            $set_counter = 1;
            foreach($matching_image[$val] as $key=>$val){
                $ar_row[$set_counter] = $val;
                $set_counter++;
            }
            $array[] = $ar_row;
        }
        
        //CSV proccess
        $this->load->library('Convertcsv');
        $csv_data = $this->convertcsv->array_to_csv($array, false);
        $this->load->helper('download');
        $data = $csv_data;
        $filename = "SELECT * from `project` where id = '".$project_id."' ";
        $get_filename = $this->db->query($filename)->result();
        foreach ($get_filename as $name){
            if($same == 'yes' && $percent == 'no'){
                $name = $name->name.'-same.csv';               
            }
            else if($same == 'yes' && $percent == 'yes'){
                $name = $name->name.'-same_percentage.csv';               
            }
            else if($same == 'no' && $percent == 'no'){
                $name = $name->name.'-different.csv';               
            }
            else if($same == 'no' && $percent == 'yes'){
                $name = $name->name.'-different_percentage.csv';               
            }
                    
        }
        force_download($name, $data); 
    }
}


/* End of file m_admin.php */
/* Location: ./application/models/m_admin.php */