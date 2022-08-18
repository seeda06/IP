

<head>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        input[type=text],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 250px;
            margin-top: 30px;
        }

        input[type=reset] {
            background-color: red;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 100px;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: burlywood;
            margin-left: 200px;
            margin-right: 200px;
            padding: 20px;
            padding-bottom: 20px;
        }

        .col-25 {
            float: center;
            width: 10%;
            margin-top: 6px;
            margin-left: 200px;
        }

        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }

        .glow {
            font-size: 26px;
            color: black;
            margin-left: 200px;      
            color: white;
            padding: 0.5em;
            display: inline-block;
            line-height: 1.3;
            background: #878787;
            vertical-align: middle;
            border-radius: 25px 0px 0px 25px;
            
        }
        .glow:before {
            content: '●';
            color: black;
            margin-right: 8px;
        }


        @-webkit-keyframes glow {
            from {
                text-shadow: 0 0 10px #fff, 0 0 15px #fff, 0 0 20px #f7d2e5, 0 0 25px #f7d2e5, 0 0 30px #f7d2e5, 0 0 40px #f7d2e5, 0 0 50px #f7d2e5;
            }

            to {
                text-shadow: 0 0 10px #fff, 0 0 15px #ffffff, 0 0 20px #ffffff, 0 0 25px #ffffff, 0 0 30px #ffffff, 0 0 40px #ffffff, 0 0 50px #ffffff;
            }
        }

        .form {
            margin-left: 10px;
        }
    </style>
      
</head>
<?php
    //ไอดีที่เราทำการดึงมาเพื่อนำมาแก้ไข
    $ID = $_GET['ID'];
    $objDB = mssql_select_db("intelle");
    $data = mssql_query("SELECT * FROM news WHERE ID='$ID'")
        or die(mssql_error());

    ?>
<body class="body">

    <h2 class="glow">เเก้ไขข่าวทรัพย์สินทางปัญญา</h2>

    <div class="container">
        <?php
        while ($info = mssql_fetch_array($data)) {
            $news = iconv("tis-620", "utf-8", $info['news']);
            $image = iconv("tis-620", "utf-8", $info['image']);

        ?>
            <form action="news/updatenews.php?ID=<?php echo $info['ID']; ?>" method="post" enctype="multipart/form-data" class="form">
                
                <label for="fname"><i class="fa fa-user" aria-hidden="true"></i>รหัส</label>
                <input name="ID" id="idnews" style="width:84%;" value="<?php echo $ID; ?>">
                <h5>เพิ่มไฟล์รูป:</h5>
                <input type="file" name="image" id="addimg" value="<?php echo $image; ?>">
                <img id="showimg" src="../uploads/<?php echo $image?>" style="height:50px;">
                <h5><label for="subject">เพิ่มข่าว</label></h5>

                <div class="row">
                    <!-- <div class="col-75">
                        <textarea name="news" placeholder="รายละเอียดข่าว" style="height:200px; width:750px" ></textarea>
                    </div>
                </div> -->
                <textarea name="news" id="detail" style="width:100px;"><?php echo $news; ?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('detail');

                function CKupdate() {
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();
                }
            </script>
                <div class="row">
                    <input type="submit" value="บันทึก">
                    <input type="reset" value="ยกเลิก">
                </div>
            </form>
        <?php } ?>
    </div>
<script>

    $("#addimg").change(function(e) {
       console.log('event',$("#addimg").val());
       
     var id=$('#idnews').val(); 
    var file_data = $('#addimg').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('image', file_data);
    form_data.append('id', id);
    console.log(form_data);                             
    $.ajax({
        url: 'news/uploadimage.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
           //('../uploads/'.php_script_response); 
           $('#showimg').attr('src', function(i, val) {
                 return '../uploads/'+php_script_response;
});
        }
     });

});
</script>
</body>
