<?php
//contient du javaScript

	require __DIR__.'/../../php/fonctions.php';
   //tronquer les tableaux à la partie visible du formulaire:
   tronq_tab($_POST['choix_SIT'],$_POST['taiSIT'],$SIT);
   tronq_tab($_POST['choix_SIQ'],$_POST['taiSIQ'],$SIQ);
   tronq_tab($_POST['choix_SIL'],$_POST['taiSIL'],$SIL);
   tronq_tab($_POST['choix_MXT'],$_POST['taiMIXTE'],$MIXTE);
   tronq_tab($_POST['choix_MASTER'],$_POST['taiMASTER'],$MASTER);
   
   
   if (isset($_POST['sauvegarder'])) //choix de sauvegarder les choix sans les valider
   {
      enregFiche();
      modifFiche($SIT,$SIQ,$SIL,$MIXTE,$MASTER);
      ?>
       <script> alert("Voeux sauvegardés avec succés!");</script><?php
   }

   else //isset($_POST['valider'])
   {
       enregFiche();
       validFiche();
       modifFiche($SIT,$SIQ,$SIL,$MIXTE,$MASTER);
       //mettre le nombre de choix de chaque sujet:
       foreach ($SIT as $choix) incNbChoixPFE($choix);
       foreach ($SIQ as $choix) incNbChoixPFE($choix);
       foreach ($SIL as $choix) incNbChoixPFE($choix);
       foreach ($MIXTE as $choix) incNbChoixPFE($choix);
       foreach ($MASTER as $choix) incNbChoixMaster($choix);
       ?><script> alert("Vos voeux ont été validés avec succés!");</script><?php
   }
   header('Location: /Formulaire');
