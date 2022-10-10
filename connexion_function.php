<?php 

function dateDiff($date1, $date2){
   $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
   $retour = array();

   $tmp = $diff;
   $retour['second'] = $tmp % 60;

   $tmp = floor( ($tmp - $retour['second']) /60 );
   $retour['minute'] = $tmp % 60;

   $tmp = floor( ($tmp - $retour['minute'])/60 );
   $retour['hour'] = $tmp % 24;

   $tmp = floor( ($tmp - $retour['hour'])  /24 );
   $retour['day'] = $tmp;

   return $retour;
}

?>


<!-- cette fonction a le role d'envoyer les emails une fois les informations necessaires sont données par l'utilisateur et que toutes les conditions sont remplis -->
<?php function sendmail($emaili){ ?>

      

<?php
   $to = $emaili;
   $subject = "Valider votre inscription chez Cardypro";
 
   // In php 7.2 and newer versions we can use an array to set the headers.
   $headers = array(
    	'MIME-Version' => '1.0',
    	'Content-type' => 'text/html;charset=UTF-8',
    	'From' => 'CardyPro',
    	'Reply-To' => 'CardyPro'
   );
 
   // Setting the value in the $name variable.
   $name = "JIBIDO";
 
   // Starting output buffer.
   
   
   ob_start();
   include("mail_inscription.php");
   $message = ob_get_contents();
   ob_end_clean();
      
   $send = mail($to, $subject, $message, $headers);
 
   if(!$send){?>
 <?php $_SESSION['sended'] = false; ?>
 <?php $return = $_SESSION['sended']; ?>
   <?php }else{
      $sent = true; ?>
 <?php $_SESSION['sended'] = true; ?>
 <?php $return = $_SESSION['sended']; ?>
   <?php }
   $send = mail($to, $subject, $message, $headers);
 
if(!$send){?>
   <?php $_SESSION['sended'] = false; ?>
   <?php $return = $_SESSION['sended']; ?>
<?php }else{
   if (!$sent) {?>
      <?php $_SESSION['sended'] = true; ?>
      <?php $return = $_SESSION['sended']; ?>
     <?php }
 
   } ?>

    <?php return $return; } ?>




<!-- cette fonction insere les informations d'inscription temporairement dans la base de donnée le temps que l'utilisateurs verifie son email -->
<?php function insertt($db){
   $vcode = rand(100000 , 999999);
   $requette = "INSERT INTO Verification(Mail, Cle_de_verification, Username, password)VALUES(?, ?, ?, ?)";
   $insert = $db->prepare($requette);
   $insertion = array();
   $insertion['execution'] = $insert->execute(array($_SESSION['mail_T'], $vcode, $_SESSION['username_T'], $_SESSION['password_T']));
   $insertion['vcode'] = $vcode;
   $_SESSION['vcode'] = $vcode;
   $email_I = $_SESSION['mail_T'];
   $_SESSION['link'] = "jibido.000webhostapp.com/inscription.php?email=$email_I&vcode=$vcode";
   
   return $insertion;
   
} ?>
<!-- cette fonction verifie si l'utilisateur est deja membre ou pas -->
<?php function is_user($db, $email){
    $requette = 'SELECT * FROM Utilisateurs WHERE Mail =?';
    $is_exist = $db->prepare($requette);
    $execution = $is_exist->execute(array(strtolower($email)));
    $find_user = $is_exist->rowCount();
    $return = array();
    $return['execution'] = $execution;
    $return['find_user'] = $find_user;
    return $return;
} ?>
<!-- fonction de supression de demande de verification -->
<?php function delete_demand($db){
  $delete = $db->prepare('DELETE FROM Verification WHERE Mail =?');
  $deleting = $delete->execute(array($_SESSION['mail_T']));
  if($deleting):   ?> 
 
 <?php $return = true; ?>
 <?php else: ?>
   <script>
   alert('Une erreur est survenu lors de la supression de votre ancienne demande')
 </script>
   <?php $return = false; ?>
<?php endif; return $return; } ?>


<?php function insert($db){ ?>
   
   <!-- on verifie si l'utilisateur a deja faits une demande d'envoie de mail -->
   <?php $verification = $db->prepare('SELECT * FROM Verification WHERE Mail =? LIMIT 1'); ?>
   <?php $verification->execute(array($_SESSION['mail_T'])); ?>
   <?php $row_result = $verification->rowCount(); ?>
   <?php if($row_result > 0): ?>
      <!-- le l'utilisateur a deja faits une demande de verification par email -->
           <!-- on recupere les informations de la demande -->
           <?php while($user_verification = $verification->fetch()){ ?>
            <!-- on insere la date de la demande dans une variable -->
                <?php $date_request = $user_verification['Date_enregistrement']; ?>
                <?php $hour_o = $user_verification['Heure_enregistrement']; ?>
                   
                <?php $minut = substr($hour_o, 3, 2); ?>  
             
                <?php $diff_minut = date('i') - $minut; ?>
                           <?php if($diff_minut > 2 OR $diff_minut == 2): ?> 
                              <?php if( delete_demand($db)): ?>
                     <?php $function = insertt($db); ?>
         <?php $execution = $function['execution']; ?>
         <?php $vcode = $function['vcode']; ?>
         <?php $sendable = true; ?>
                     <?php else: ?>
                        <?php $execution = false; ?>
                     <?php endif ?>
                              <?php else: ?>
                                 <!-- si n-ya pas ecoulement de deux minute depuis que l'utilisateur a faits une demande -->
                                 <?php $sendable = false; ?>
                                 <?php $vcode = false; ?>
                                 <script>
                                    alert('Vueiller patienter 2 minutes avant de re-essayer');
                                 </script>
                                  <?php $execution = true; ?>
                              <?php endif ?>


            <?php } ?>
      <?php else: ?>
         <!-- si l'utilisateur n'as pas faits de demande de verification par email -->
         <?php $function = insertt($db); ?>
         <?php $execution = $function['execution']; ?>
         <?php $vcode = $function['vcode']; ?>
         <?php $sendable = true; ?>
      <?php endif ?>

    <?php $return = array(); ?>
    <?php $return['execution'] = $execution; ?>
    <?php $return['vcode'] = $vcode; ?>
    <?php $return['sendable'] = $sendable; ?>
   
   <?php return $return; } ?>