<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="styles/try/try.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="script.js"></script>
<div class="upload_form_box">

<form>
    <div class="upper_part">
        <div class="title">New Product</div>
        <div class=submit_box>
            <button type="submit" id="upload_submit" onclick="get_upload(event);">Upload</button>
        </div>
    </div>

    <div class="form_section" id="section_1">
        <div class="title">
            <span>1</span>Information 
        </div>
        <!-- 產品名稱 -->
        <div class="input_box">
            <span>Name *</span>
            <input required id="product_name" name="pName" type="text" placeholder="Jeans" minlength="1" maxlength="10"/>
        </div>
        <!-- 產品金額 -->
        <div class="input_box">
            <span>Price *</span>
            <input id="product_price" name="unitPrice" type="text" maxlength="15"/>
        </div>
        <!-- 產品說明 -->
        <div class="input_box">
            <span>Descrition *</span>
            <textarea id="editor"></textarea>
            <script>
                ClassicEditor
                .create(document.querySelector('#editor'), {
                    plugins: [ 'Essentials', 'Paragraph', 'Bold', 'Italic', 'List'],
                    toolbar: [ 'undo', 'redo', '|', 'bold', 'italic', 'list']
                    
                })
                .catch(error => {
                    console.error(error);
                });
            </script>
        </div>
        <!-- 產品圖片 -->
        <div class="image_box">
            <span class="title">Picture * </span>
            <div class="file_box">
                
                <label class="adding_part" id="add_image">
                    <div class="icon" id="to_put_image">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 8h.01"></path>
                            <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5"></path>
                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"></path>
                            <path d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54"></path>
                            <path d="M16 19h6"></path>
                            <path d="M19 16v6"></path>
                        </svg>
                    </div>
                    Upload a image of your product
                    <input id="image_name" name="image_path" type="file" onchange="loadFile(event)"/>
                </label>
            </div>
        </div>
    </div>
    <div class="form_section" id="section_2">
        <div class="title">
            <span>2</span>Settings
        </div>
        <!-- 產品類型 -->
        <div class="input_box">
            <span>Category *</span>
            <select>
                <option>Tops</option>
                <option>Shirts</option>
            </select>
        </div>
    </div>
</form>
</div>



<div class="upload_form_box">
               <div class="title">UPLOAD</div>
                <form method="POST" action="" enctype="multipart/form-data" id="upload_form"> 
                    <div class="file_box">
                        <img id="output" src="#" />
                        <label class="custom-file-upload" id="add_image">
                                +
                                Product Photo<input id="image_name" name="image_path" type="file" onchange="loadFile(event)"/>
                        </label>
                       
                    </div>
                    <div class="other_input">
                        <div class="input_box">
                            <label>Name</label>
                            <div class="flex">
                                <input id="product_name" name="pName" type="text" placeholder="Jeans" minlength="1" maxlength="10" />
                            </div>    
                        </div>
                        <div class="input_box">
                            <label>Category</label>
                            <div class="flex">
                                <select name="category">
                                    <?php // get all category
                                        $sql = "SELECT * FROM `Category`";
                                        $all_categories = $db -> query($sql);
                                        foreach($all_categories as $category){
                                    ?>
                                            <option><?=$category["cName"]?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>    
                        </div>
                        <div class="input_box">
                            <label for="price">Enter amount</label>
                            <div class="flex">
                                <input id="product_price" name="unitPrice" type="text" maxlength="15"/>
                            </div>
                        </div>
                        <div class="input_box">
                            <label>Descrition </label>
                            <div class="flex">
                                <textarea id="product_description" class="form-field" placeholder="Description" rows="6" name="description" ></textarea>
                            </div>
                        </div>
                        <div class=submit_box>
                            <button type="submit" id="upload_submit" onclick="get_upload(event);">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
