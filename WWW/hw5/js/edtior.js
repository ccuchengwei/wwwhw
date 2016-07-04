            $(function() {
                   $('#codebtn').attr('disabled',true);
                   $('#edit_div').attr('contenteditable',false);
                   $('#ytdiv').hide();
                   
                });
             var code_check = 1;
            function tcode(){
               if(!code_check){
               $('#edit_div').attr('contenteditable',false);
               var content1 = $('#edit_div').html();
               $('#edit_div').html("<textarea name='sourcecode' id='sourcecode'  style='width:550px;height:500px;'>"+content1+"</textarea>");
               $('#codebtn').addClass("active");
               $('#htmlbtn').removeClass("active");
               $('#codebtn').attr('disabled',true);
               $('#htmlbtn').attr('disabled',false);
               code_check = 1;
               }
            }
            function thtml(){
                $('#edit_div').attr('contenteditable',true);
               var content1 = $('#sourcecode').val();
                content1 = content1.replace(/\n/g,"<br />");
               $('#sourcecode').remove();
               $('#edit_div').html(content1);
               $('#htmlbtn').addClass("active");
               $('#codebtn').removeClass("active");
               $('#htmlbtn').attr('disabled',true);
               $('#codebtn').attr('disabled',false);
               code_check = 0;
              
            }
            function fontStyle(s) {
              if (s == "b") {
                if(code_check)
                 {
                    
                   $('#sourcecode').val(textSelection(s)); 
                 }
                 else
                 {
                    document.execCommand("bold"); 
                 }
              } 
              else if (s == "i") {
                 if(code_check)
                 {
                    
                   $('#sourcecode').val(textSelection(s)); 
                 }
                 else
                 {
                    document.execCommand("Italic"); 
                 }
              }
              else if (s == "red") {
                 if(code_check)
                 {
                    
                   $('#sourcecode').val(textSelection("Red")); 
                 }
                 else
                {document.execCommand("foreColor",false,"red");}
              }
              else if (s == "green") {
                  if(code_check)
                 {
                    
                   $('#sourcecode').val(textSelection("Green")); 
                 }
                 else
                {document.execCommand("foreColor",false,"green");}
              }
              else if (s == "blue") {
             if(code_check)
                 {
                    
                   $('#sourcecode').val(textSelection("Blue")); 
                 }
                 else
                {document.execCommand("foreColor",false,"blue");}
              }
            }
                function textSelection(str)
                    {
                    var textComponent = document.getElementById('sourcecode');
                    var selectedText;

                    // Mozilla version
                    if (textComponent.selectionStart != undefined)
                    {
                    var startPos = textComponent.selectionStart;
                    var endPos = textComponent.selectionEnd;
                    selectedText = textComponent.value.substring(startPos, endPos)
                    var prefix = textComponent.value.substring(0,startPos);
                    var suffix = textComponent.value.substring(endPos);
                    }
                      
                     return prefix+"<"+str+">"+selectedText+"</"+str+">"+suffix;
                    }
                    var yt_check = 0;
                    
                 var video_count=0;
                function ytshow(){
                
                    if(yt_check)
                    {
                    $('#ytdiv').hide();
                    $('#ytbtn').removeClass("active");
                    yt_check = 0;
                    }
                    else
                    {
                    $('#ytdiv').show(); 
                    $('#ytbtn').addClass("active");
                    yt_check = 1;
                    }
                    
                    }
                    

              function onyt(){
              if(code_check)
                 {
                    var textComponent = document.getElementById('sourcecode');
                    var selectedText;

                    // Mozilla version
                    if (textComponent.selectionStart != undefined)
                    {
                    var startPos = textComponent.selectionStart;
                    var endPos = textComponent.selectionEnd;
                    selectedText = textComponent.value.substring(startPos, endPos)
                    var prefix = textComponent.value.substring(0,startPos);
                    var suffix = textComponent.value.substring(endPos);
                    }
                       $('#sourcecode').val(prefix+'<iframe width="400" height="300" src="https://www.youtube.com/embed/'+$('#ytid').val()+'" frameborder="0" allowfullscreen></iframe>'+suffix); 
                     
                  
                 }
               else
                {
                    document.execCommand('insertHTML', null, '<iframe width="420" height="315" src="https://www.youtube.com/embed/'+$('#ytid').val()+'" frameborder="0" allowfullscreen></iframe>');
                }
              }
       var createarticleask=function(){ 
            tcode();
            var content=$('#sourcecode').val().replace(/\n/g,"<br />");
            $.ajax({
                url:"recivearticle.php" ,
                data: {opcode:'1',userid:$('#userid').html(),title:$('#Title').val(),content:content},
                type:"POST",

                success: function(msg){
                    
                
                   
                

                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                 }
            });
        } 
        
         var editarticle=function(){ 
        
            tcode();
            var content=$('#sourcecode').val().replace(/\n/g,"<br />");
            
            $.ajax({
                url:"recivearticle.php" ,
                data: {opcode:'3',articleid:$('#articleid').html(),title:$('#Title').val(),content:content},
                type:"POST",

                success: function(msg){
                

                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                 }
            });
            
        }
        var editarticleask=function(){ 
            
   
            $.ajax({
                url:"recivearticle.php" ,
                data: {opcode:'2',articleid:$('#articleid').html()},
                type:"POST",
                

                success: function(msg){
                    var contact = JSON.parse(msg);
                $('#Title').val(contact.title);
                $('#sourcecode').val(contact.content);
                
                

                },

                 error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                 }
            });
        }
            