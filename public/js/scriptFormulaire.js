        var cptSIT=0;
        var cptSIQ=0;
        var cptSIL=0;
        var cptMIXTE=0;
        var cptMASTER=0;
       

       function addSIT()
       {
        
          if (cptSIT<10){
            cptSIT++;
            document.getElementById('SITcell'+cptSIT).style.visibility='visible';

            taiSIT=document.getElementById('taiSIT');
            taiSIT.setAttribute('value',cptSIT);
          } 
       }
       
       function addSIQ()
       {
          if (cptSIQ<10){
            cptSIQ++;
            document.getElementById('SIQcell'+cptSIQ).style.visibility='visible';

            taiSIQ=document.getElementById('taiSIQ');
            taiSIQ.setAttribute('value',cptSIQ);
          }
      }


       function addSIL()
       {
        
          if (cptSIL<10){
            cptSIL++;
            document.getElementById('SILcell'+cptSIL).style.visibility='visible';

            taiSIL=document.getElementById('taiSIL');
            taiSIL.setAttribute('value',cptSIL);
          }
        }
      
       function addMIXTE(){
          if (cptMIXTE<10){
            cptMIXTE++;
            document.getElementById('MIXTEcell'+cptMIXTE).style.visibility='visible';

            taiMIXTE=document.getElementById('taiMIXTE');
            taiMIXTE.setAttribute('value',cptMIXTE);
            }
            }
        
        function addMASTER(){
          if (cptMASTER<10){
            cptMASTER++;
            document.getElementById('MASTERcell'+cptMASTER).style.visibility='visible';

            taiMASTER=document.getElementById('taiMASTER');
            taiMASTER.setAttribute('value',cptMASTER);
            }
        }
        
       function subSIT()
       {
          if (cptSIT>0){
            document.getElementById('SITcell'+cptSIT).style.visibility='hidden';
            cptSIT--;

            taiSIT=document.getElementById('taiSIT');
            taiSIT.setAttribute('value',cptSIT);
            }
          }
        
        function subSIQ()
        {
          if (cptSIQ>0){
            document.getElementById('SIQcell'+cptSIQ).style.visibility='hidden';
            cptSIQ--;

            taiSIQ=document.getElementById('taiSIQ');
            taiSIQ.setAttribute('value',cptSIQ);
            }
        }

        function subSIL()
        {
          if (cptSIL>0){
            document.getElementById('SILcell'+cptSIL).style.visibility='hidden';
            cptSIL--;

            taiSIL=document.getElementById('taiSIL');
            taiSIL.setAttribute('value',cptSIL);
            }
        }
        
        function subMIXTE(){
          if (cptMIXTE>0){
            document.getElementById('MIXTEcell'+cptMIXTE).style.visibility='hidden';
            cptMIXTE--;

            taiMIXTE=document.getElementById('taiMIXTE');
            taiMIXTE.setAttribute('value',cptMIXTE);
            }
        }
        
        function subMASTER(){
          if (cptMASTER>0){
            document.getElementById('MASTERcell'+cptMASTER).style.visibility='hidden';
            cptMASTER--;

            taiMASTER=document.getElementById('taiMASTER');
            taiMASTER.setAttribute('value',cptMASTER);
            }
          }
        
        function enableOrNot()//activer ou désactiver les boutons sauvegarder et valider
        {
          var repetition1=isRepeatedSIQ();
          var repetition2=isRepeatedSIT();
          var repetition3=isRepeatedSIL();
          var repetition4=isRepeatedMXT();
          var repetition5=isRepeatedMASTER();
          var repetition=(repetition1 || repetition2 || repetition3 || repetition4 || repetition5);

          //activer ou desactiver le bouton "sauvegarder":
          if ((!repetition) && (cptSIT>0 || cptSIQ>0 || cptSIL>0 || cptMIXTE>0 || cptMASTER>0)) document.getElementById('sauvegarder').disabled=false; 
          else document.getElementById('sauvegarder').disabled=true;

          //activer ou desactiver le bouton "valider" 
          if ((!repetition) && (cptSIT>=3 && cptSIQ>=3 && cptSIL>=3 && cptMIXTE>=3 && cptMASTER>=2)) document.getElementById('valider').disabled=false; 
          else document.getElementById('valider').disabled=true;
        }
        
        function isRepeatedSIT()//renvoie "true" s'il y a un choix SIT répété et "false" sinon
        {   
            var repeter=false;
            var selectActuel,valeurActuelle,select,valeur;

            if (cptSIT==1) document.getElementById('choix_SIT1').style.border="1px solid black";
            
            if (cptSIT>1)
            { 
              j=1;
              while(j<cptSIT && !repeter)
              {
                selectActuel = document.getElementById('choix_SIT'+j);
                valeurActuelle = selectActuel.options[selectActuel.selectedIndex].value;
                i=j+1;
                while (i<=cptSIT && !repeter)
                {
                   select=document.getElementById('choix_SIT'+i);
                   valeur = select.options[select.selectedIndex].value;
                   if (valeurActuelle==valeur)
                   {
                    repeter=true;
                    selectActuel.style.border="2px solid red";
                    select.style.border="2px solid red";
                    document.getElementById("plus_SIT").disabled=true;
                   }
                   else
                   {
                       selectActuel.style.border="1px solid black";
                       select.style.border="1px solid black";
                   }
                   i++;
                }
                  j++;
              }
            }

            if (repeter==false)  document.getElementById("plus_SIT").disabled=false;
            else { alert('Vous avez effectué deux choix identiques dans la spécialité SIT');}
            return repeter;
          }

          function isRepeatedSIQ()//renvoie "true" s'il y a un choix SIT répété et "false" sinon
        {   
            var repeter=false;
            var selectActuel,valeurActuelle,select,valeur;
            
            if (cptSIQ==1) document.getElementById('choix_SIQ1').style.border="1px solid black";
            
            if (cptSIQ>1)
            { 
              j=1;
              while(j<cptSIQ && !repeter)
              {
                selectActuel = document.getElementById('choix_SIQ'+j);
                valeurActuelle = selectActuel.options[selectActuel.selectedIndex].value;
                i=j+1;
                while (i<=cptSIQ && !repeter)
                {
                   select=document.getElementById('choix_SIQ'+i);
                   valeur = select.options[select.selectedIndex].value;
                   if (valeurActuelle==valeur)
                   {
                    repeter=true;
                    selectActuel.style.border="1px solid red";
                    select.style.border="1px solid red";
                    document.getElementById("plus_SIQ").disabled=true;
                   }
                   else
                   {
                       selectActuel.style.border="1px solid black";
                       select.style.border="1px solid black";
                   }
                   i++;
                }
                  j++;
              }
            }

            if (repeter==false) document.getElementById("plus_SIQ").disabled=false;
            else { alert('Vous avez effectué deux choix identiques dans la spécialité SIQ');}
            return repeter;
          }
          
          function isRepeatedSIL()//renvoie "true" s'il y a un choix SIT répété et "false" sinon
        {   
            var repeter=false;
            var selectActuel,valeurActuelle,select,valeur;
            
            if (cptSIL==1) document.getElementById('choix_SIL1').style.border="1px solid black";
            
            if (cptSIL>1)
            { 
              j=1;
              while(j<cptSIL && !repeter)
              {
                selectActuel = document.getElementById('choix_SIL'+j);
                valeurActuelle = selectActuel.options[selectActuel.selectedIndex].value;
                i=j+1;
                while (i<=cptSIL && !repeter)
                {
                   select=document.getElementById('choix_SIL'+i);
                   valeur = select.options[select.selectedIndex].value;
                   if (valeurActuelle==valeur)
                   {
                    repeter=true;
                    selectActuel.style.border="2px solid green";
                    select.style.border="2px solid green";
                    document.getElementById("plus_SIL").disabled=true;
                   }
                   else
                   {
                       selectActuel.style.border="1px solid black";
                       select.style.border="1px solid black";
                   }
                   i++;
                }
                  j++;
              }
            }

            if (repeter==false) document.getElementById("plus_SIL").disabled=false;
            return repeter;
          }

          function isRepeatedMXT()//renvoie "true" s'il y a un choix SIT répété et "false" sinon
        {   
            var repeter=false;
            var selectActuel,valeurActuelle,select,valeur;
            
            if (cptMIXTE==1) document.getElementById('choix_MXT1').style.border="1px solid black";
            
            if (cptMIXTE>1)
            { 
              j=1;
              while(j<cptMIXTE && !repeter)
              {
                selectActuel = document.getElementById('choix_MXT'+j);
                valeurActuelle = selectActuel.options[selectActuel.selectedIndex].value;
                i=j+1;
                while (i<=cptMIXTE && !repeter)
                {
                   select=document.getElementById('choix_MXT'+i);
                   valeur = select.options[select.selectedIndex].value;
                   if (valeurActuelle==valeur)
                   {
                    repeter=true;
                    selectActuel.style.border="2px solid red";
                    select.style.border="2px solid red";
                    document.getElementById("plus_MIXTE").disabled=true;
                   }
                   else
                   {
                       selectActuel.style.border="1px solid black";
                       select.style.border="1px solid black";
                   }
                   i++;
                }
                  j++;
              }
            }

            if (repeter==false) document.getElementById("plus_MIXTE").disabled=false;
            else { alert('Vous avez effectué deux choix identiques dans la spécialité MIXTE');}
            return repeter;
          }

          function isRepeatedMASTER()//renvoie "true" s'il y a un choix SIT répété et "false" sinon
        {   
            var repeter=false;
            var selectActuel,valeurActuelle,select,valeur;
            
            if (cptMASTER==1) document.getElementById('choix_MASTER1').style.border="1px solid black";
            
            if (cptMASTER>1)
            { 
              j=1;
              while(j<cptMASTER && !repeter)
              {
                selectActuel = document.getElementById('choix_MASTER'+j);
                valeurActuelle = selectActuel.options[selectActuel.selectedIndex].value;
                i=j+1;
                while (i<=cptMASTER && !repeter)
                {
                   select=document.getElementById('choix_MASTER'+i);
                   valeur = select.options[select.selectedIndex].value;
                   if (valeurActuelle==valeur)
                   {
                    repeter=true;
                    selectActuel.style.border="2px solid red";
                    select.style.border="2px solid red";
                    document.getElementById("plus_MASTER").disabled=true;
                   }
                   else
                   {
                       selectActuel.style.border="1px solid black";
                       select.style.border="1px solid black";
                   }
                   i++;
                }
                  j++;
              }
            }

            if (repeter==false) document.getElementById("plus_MASTER").disabled=false;
            else { alert('Vous avez effectué deux choix identiques dans la spécialité Master');}
            return repeter;
          }