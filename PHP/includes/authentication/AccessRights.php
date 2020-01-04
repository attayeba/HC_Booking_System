<?php
    include_once("User.php");
    class AccessRights{

        # different access rights levels #

        // For Receptionist users only
        const AdminReceptionist = 3;

        // For Doctors, Nurses and Therapists
        const AdminHCP = 2;

        // For Patient users only
        const Patient = 1;

        #### These functions kill the page if the user lacks the necessary access ####

        public static function verify_admin_receptionist(){
            AccessRights::verify(AccessRights::AdminReceptionist, "Admin Receptionist");
        }

        public static function verify_admin_hcp(){
            AccessRights::verify(AccessRights::AdminHCP, "Admin HCP");
        }

        public static function verify_patient(){
            AccessRights::verify(AccessRights::Patient, "Patient");
        }

        private static function verify($Access, $Message){
            $User = User::get_user_info();
            if($User->AccessLevel < $Access){
                $access = $Message;
                include("forbiden.php");
                include("../includes/footer.php");
                die();
            }
        }

        ### These functions enforce that a user MUST be a certain level of privilige. No more. No less

        public static function require_admin_receptionist_access(){
            return AccessRights::require_access(AccessRights::AdminReceptionist, "Admin Receptionist");
        }

        public static function require_hcp_access(){
            return AccessRights::require_access(AccessRights::AdminHCP, "Admin HCP");
        }

        public static function require_patient_access(){
            return AccessRights::require_access(AccessRights::Patient, "Patient");
        }


        private static function require_access($Access, $Message){
            $User = User::get_user_info();
            return $User->AccessLevel == $Access;
        }


        #### These functions return a boolean representing whether the user has the specified access ####

        public static function has_admin_receptionist_access(){
            return AccessRights::has_access(AccessRights::AdminReceptionist);
        }

        public static function has_admin_hcp_access(){
            return AccessRights::has_access(AccessRights::AdminHCP);
        }

        public static function has_admin_patient_access(){
            return AccessRights::has_access(AccessRights::Patient);
        }

        private static function has_access($Access){
            $User = User::get_user_info();
            return $User->AccessLevel >= $Access;
        }

        
    }
?>