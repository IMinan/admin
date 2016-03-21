<?php
/* Varet img Upload Framawork */
include 'class.upload.php';

/*
@name: site_url
@description: bu fonksiyon ile sitenin default URL adresini alabiliriz
@developer: mustafa tanriverdi
@date: 05-12-2015
@update_date:
*/
function site_url($variable='')
{
	global $site_url;
	if($variable == '')
	{
		return $site_url;
	}
	else
	{
		return $site_url.'/'.$variable;
	}

}

/*
@name: theme_url
@description: bu fonksiyon ile sitenin default Theme URL adresini alabiliriz
@developer: Muhammet İnan
@date: 26-01-2016
@update_date:
*/
function theme_url($variable='')
{
	global $theme_url;
	if($variable == '')
	{
		return $theme_url;
	}
	else
	{
		return $theme_url.'/'.$variable;
	}

}




if(isset($_GET['list_id'])){$explode = explode('-', $_GET['list_id']);$_GET['id'] = $explode[0];}
if(isset($_GET['corporate_id'])){$explode = explode('-', $_GET['corporate_id']);$_GET['id'] = $explode[0];}





/*
@name: get_inc()
@description: bu fonksiyon ile sitenin PHP(proje-temanın kök dizi) dizin klasörünü alabiliriz
@developer: mustafa tanriverdi
@date: 05-12-2015
@update_date:
*/
function get_inc($file_path='')
{
	global $site_url;
	if($site_url == '')
	{
		return $site_url;
	}
	else
	{
		return $site_url.'/'.$variable;
	}
}










/* ------------------------------------------------------------------------------- */
/*  *****.  PRODUCT META
/* ------------------------------------------------------------------------------- */



/*
@name: get_list_meta
@description: urune ait meta bilgilerini gosterir
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function get_list_meta($list_id_OR_query, $_key='', $val_1='', $array_return=true)
{
	$return_array = '';
	if(is_array($list_id_OR_query))
	{
		$result = mysqli()->query("SELECT * FROM list_meta WHERE ".$list_id_OR_query['query']."");
		$array_return = $_key;
	}
	else
	{
		$list_id = $list_id_OR_query;
		if($_key == '' AND $val_1 == '')
		{
			$result = mysqli()->query("SELECT * FROM list_meta WHERE list_id='$list_id'");
		}
		elseif($_key != '' AND $val_1 == '')
		{
			$result = mysqli()->query("SELECT * FROM list_meta WHERE list_id='$list_id' AND _key='$_key'");
		}
		else
		{
			$result = mysqli()->query("SELECT * FROM list_meta WHERE list_id='$list_id' AND _key='$_key' AND val_1='$val_1'");
		}
	}

	if($result->num_rows == 1 and $array_return == true)
	{
		$_return = $result->fetch_assoc();
		$return_array[$_return['id']] = $_return;
	}
	elseif($result->num_rows == 1 and $array_return==false)
	{
		$return_array = $result->fetch_assoc();
	}
	elseif($result->num_rows > 1 and $array_return==true)
	{
		while($list = $result->fetch_object())
		{
			$return_array[$list->id] = get_object_vars($list);
		}
	}
	else
	{
		$return_array = false;
	}

	return $return_array;
}




/*
@name: add_list_meta
@description: bu fonksiyon ile mysql veritabanına veri eklerken güvenlik kontrollerini alıyoruz
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function add_list_meta($list_id, $array=array())
{
	$array['list_id'] = $list_id;
	$array['user_id'] = active_user('id');

	foreach($array as $name=>$value)
	{
		if(isset($table_name)){$table_name = $table_name.', '.$name;}else{$table_name = $name;}
		if(isset($table_value)){$table_value = $table_value.", '".$value."'";}else{$table_value = "'".$value."'";}
	}

	mysqli_query(mysqli(), "INSERT INTO list_meta (".$table_name.") VALUES (".$table_value.")");
	if(mysqli_insert_id(mysqli()) > 0)
	{
		$insert_id = mysqli_insert_id(mysqli());
		return $insert_id;
	}
	else
	{
		return false;
	}
}





/* ------------------------------------------------------------------------------- */
/*  *****.  Pages
/* ------------------------------------------------------------------------------- */
/*
@name: add_pages
@description: yeni bir sayfa açmak için kullanılan fonksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/

function add_pages($title, $content)
{
	$title = trim(mysqli()->real_escape_string($title));
	$content = trim(mysqli()->real_escape_string($content));
	$date = date("Y-m-d H:i:s");
	$query = mysqli_query(mysqli(), "INSERT INTO pages (date, title, content) VALUES ('".$date."', '".$title."', '".$content."')");
	if($query){
		return true;
	}else{ }
}

/*
@name: edit_page
@description: id si verilen sayfasının verilenini düzenlemeye yarayan fonksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/

function edit_pages($id, $title, $content)
{
	if(!$title || !$content){
		echo get_alert('Tüm Alanları eksiksiz şekilde Doldurunuz');
	}else{
		$title = trim(mysqli()->real_escape_string($title));
		$content = trim(mysqli()->real_escape_string($content));
		$date = date("Y-m-d H:i:s");
		$query = mysqli_query(mysqli(), "UPDATE pages SET update_date='". $date ."', title='". $title ."', content='". $content ."' WHERE id='". $id ."'");
		if($query){
			return true;
		}
	}
}

/*
@name: get_list_pages
@description: Veritabanındaki sayfaları listleyen funksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/
function get_list_pages()
{
	$result = mysqli()->query("SELECT * FROM pages ORDER BY id DESC");
	if($result->num_rows > 0){
		return $result;
	}else{
		return false;
	}
}

/*
@name: get_page
@description: id si girilen sayfanın bilgilerini object olarak veren fonksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/
function get_page($id)
{
	$result = mysqli()->query("SELECT * FROM pages WHERE id='$id'");
	if($result->num_rows > 0){
		return $result->fetch_object();
	}else{
		return false;
	}
}

/*
@name: delete_page
@description: id is girilen sayfasının status unu 0 yapan fonksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/

function delete_page($id)
{
	$query = mysqli()->query("UPDATE pages SET status='0' WHERE id='$id'");
	if(mysqli_affected_rows(mysqli()) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}


/* ------------------------------------------------------------------------------- */
/*  *****.  News
/* ------------------------------------------------------------------------------- */
/*
@name: add_news
@description: yeni bir haber sayfası açmak için kullanılan fonksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/

function add_news($title, $content, $list_img)
{

	$title = trim(mysqli()->real_escape_string($title));
	$content = trim(mysqli()->real_escape_string($content));
	$date = date("Y-m-d H:i:s");
	$query = mysqli_query(mysqli(), "INSERT INTO news (date, title, list_img, content) VALUES ('".$date."', '".$title."', '".$list_img."', '".$content."')");
	if($query){
		return true;
	}else{ }
}

/*
@name: edit_news
@description: id si verilen haberin verilenini düzenlemeye yarayan fonksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/

function edit_news($id, $title, $content, $list_img)
{
	if(!$title || !$content){
		echo get_alert('Tüm Alanları eksiksiz şekilde Doldurunuz');
	}else{
		$title = trim(mysqli()->real_escape_string($title));
		$content = trim(mysqli()->real_escape_string($content));
		$date = date("Y-m-d H:i:s");
		$query = mysqli_query(mysqli(), "UPDATE news SET update_date='". $date ."', title='". $title ."', content='". $content ."', list_img='". $list_img ."' WHERE id='". $id ."'");
		if($query){
			return true;
		}
	}
}

/*
@name: get_list_news
@description: Veritabanındaki haberlerin listleyen funksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/
function get_list_news()
{
	$result = mysqli()->query("SELECT * FROM news ORDER BY id DESC");
	if($result->num_rows > 0){
		return $result;
	}else{
		return false;
	}
}

/*
@name: get_news
@description: id si girilen sayfanın bilgilerini object olarak veren fonksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/
function get_news($id)
{
	$result = mysqli()->query("SELECT * FROM news WHERE id='$id'");
	if($result->num_rows > 0){
		return $result->fetch_object();
	}else{
		return false;
	}
}

/*
@name: delete_news
@description: id is girilen sayfasının status unu 0 yapan fonksiyon
@developer: Muhamet İnan
@date: 26-01-2016
@update_date: NULL
*/

function delete_news($id)
{
	$query = mysqli()->query("UPDATE news SET status='0' WHERE id='$id'");
	if(mysqli_affected_rows(mysqli()) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}






/* ------------------------------------------------------------------------------- */
/*  *****.  Options
/* ------------------------------------------------------------------------------- */
/*
@name: add_options
@description: options tablosun ekleme yapmak için kullanılan fonksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/

function add_options($meta_key, $val_1)
{
	$result = mysqli()->query("SELECT * FROM options WHERE meta_key='$meta_key'");
	if($result->num_rows > 0){
		$query = mysqli()->query("UPDATE options SET val_1='$val_1' WHERE meta_key='$meta_key'");
		if($query)
		{
			return true;
		}
		else {
			return false;
		}
		exit;
	}else{
		$query = mysqli()->query("INSERT INTO options (meta_key, val_1) VALUES ('".$meta_key."', '".$val_1."')");

	}
}


/*
@name: get_options
@description: options tablosun ekleme yapmak için kullanılan fonksiyon
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/

function get_options($meta_key, $vals='', $echo=false)
{
	$result = mysqli()->query("SELECT * FROM options WHERE meta_key='$meta_key'");
	if($result->num_rows > 0){
		$return = $result->fetch_object();

		if($vals!=''){
			$return = $return->$vals;
		}

		if($echo)
		{
			echo $return;
		}
		else {
			return $return;
		}

	}else{
		return false;
	}
}

function the_get_options($meta_key)
{
	echo get_options($meta);
}

/*
@name: delete_options
@description: options tablosundaki verileri silmek için kullanılır
@developer: Muhamet İnan
@date: 27-01-2016
@update_date: NULL
*/

function delete_options($meta_key)
{
	$result = mysqli()->query("DELETE FROM options WHERE meta_key='$meta_key'");
	if($result){
		return true;
	}else{
		return false;
	}
}


/*
@name: img_upload
@description: resimleri kayıt ederken alınması gereken güvenliklerin tamamını içeren funksiyon
@developer: Muhamet İnan
@date: 29-01-2016
@update_date: NULL
*/

function img_upload($foo){
	$new_image_name = date('YmdHis');
	$foo->file_new_name_body =$new_image_name;
   $foo->image_resize = true;
   $foo->image_x = 400;
	 $foo->image_convert = 'jpg';
   $foo->image_ratio_y = true;
   $foo->Process('../upload/news');
   if ($foo->processed) {
     	return $foo;
     $foo->Clean();
   } else {
     return false;
   }
}


/* ------------------------------------------------------------------------------- */
/*  *****.  LIST STOCK
/* ------------------------------------------------------------------------------- */




/*
@name: add_list_stock
@description: stok ekleme ve cikarma
@developer: mustafa tanriverdi
@date: 19-01-2016
@update_date: NULL
*/
function add_list_stock($list_id, $in_out, $quantity)
{
	$array['date'] = date('Y-m-d H:i:s');
	$array['user_id'] = active_user('id');
	$array['microtime'] = form_input_control($_POST['microtime']);
	$array['list_id'] = $list_id;
	$array['in_out'] = $in_out;
	$array['quantity'] = $quantity;
	$table_name = insert_array_table($array);
	$table_value = insert_array_value($array);

	$query = mysqli()->query("SELECT * FROM list_stock WHERE microtime='".$array['microtime']."' AND user_id='".active_user('id')."'");
	if($query->num_rows < 1)
	{
		$query = mysqli()->query("INSERT INTO list_stock ($table_name) VALUES ($table_value)");
		if($query)
		{
			return mysqli()->insert_id;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}





/*
@name: calc_list_stock
@description: stok kartına ait stokları hesaplar ve net stok sonucunu döndürür
@developer: mustafa tanriverdi
@date: 19-01-2016
@update_date: NULL
*/
function calc_list_stock($list_id)
{
	$res = mysqli()->query("SELECT SUM(quantity) FROM list_stock WHERE list_id='$list_id' AND in_out='0'");
	$row = mysqli_fetch_row($res);
	$in = $row[0];

	$res = mysqli()->query("SELECT SUM(quantity) FROM list_stock WHERE list_id='$list_id' AND in_out='1'");
	$row = mysqli_fetch_row($res);
	$out = $row[0];

	$total = $in-$out;

	$query = mysqli()->query("UPDATE list SET quantity='$total' WHERE id='$list_id'");
	if($query)
	{
		return $total;
	}
	else
	{
		return false;
	}
}







/* ------------------------------------------------------------------------------- */
/*  *****.  LIST
/* ------------------------------------------------------------------------------- */


/*
@name: add_list
@description: listemele ekleme icin
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function add_list($array)
{
	$array['date'] = date('Y-m-d H:i:s');
	$array['user_id'] = active_user('id');
	$array['microtime'] = form_input_control($_POST['microtime']);
	$array['guid'] = $sef_url = sef_url(active_user('company_name').'-'.brand($array['brand_id']).'-'.$array['code'].'-'.$array['code_type'].'');
	$table_name = insert_array_table($array);
	$table_value = insert_array_value($array);


	// eger kullanici listesini daha onceden silmis ve tekrar ekliyor ise bunun kontrolunu saglayalim ve veritabanini duzenli tutalim
	$query = mysqli()->query("SELECT * FROM list WHERE
		status='0'
		AND user_id='".active_user('id')."'
		AND code='".$array['code']."'
		AND code_type='".$array['code_type']."'
		AND brand_id='".$array['brand_id']."'
	");
	if($query->num_rows > 0)
	{
		$deleted_list = $query->fetch_object();
		if(update_list($deleted_list->id, array('status'=>'1', 'price'=>$array['price'], 'currency'=>$array['currency'])))
		{
			return $deleted_list->id;
		}
	}
	else
	{
		$query = mysqli()->query("SELECT * FROM list WHERE microtime='".$array['microtime']."' AND user_id='".active_user('id')."'");
		if($query->num_rows < 1)
		{
			mysqli_query(mysqli(), "INSERT INTO list (".$table_name.") VALUES (".$table_value.")");
			$insert_id = mysqli_insert_id(mysqli());
			if($insert_id > 0)
			{
				// Markaya ait toplam urun sayisi
				$count_brand = mysqli()->query("SELECT * FROM list WHERE brand_id='".$array['brand_id']."'");
				$update_brand = mysqli()->query("UPDATE product_brand SET count='".$count_brand->num_rows."' WHERE id='".$array['brand_id']."'");

				// SEF URL GUNCELLE
				$array['guid'] = $insert_id.'-'.$array['guid'];
				if(update_list($insert_id, array('guid'=>$array['guid'])))
				{
					$barcode = trim(brand($array['brand_id'],'name').' '.$array['code'].' '.$array['code_type']);
					add_list_meta($insert_id, array('_key'=>'barcode', 'val_1'=>$barcode));
					return $insert_id;
				}
			}
			else
			{
				return false;
			}
		}
	}
}



/*
@name: update_list
@description: liste güncelleme
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function update_list($id, $array)
{
	$update_value = update_array_string($array);


	$query = mysqli()->query("UPDATE list SET $update_value WHERE id='$id' AND user_id='".active_user('id')."'");
	if(mysqli_affected_rows(mysqli()) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}



/*
@name: delete_list
@description: liste güncelleme
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function delete_list($id)
{
	$query = mysqli()->query("UPDATE list SET status='0' WHERE id='$id' AND user_id='".active_user('id')."'");
	if(mysqli_affected_rows(mysqli()) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}






/*
@name: get_list_brand
@description: kategorileri listelere degiskene atar
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function get_list_brand()
{
	$return_array;
	$result = mysqli()->query("SELECT id,status,name,count FROM product_brand WHERE status='1' ORDER BY alignment ASC");
	while($list = $result->fetch_object())
	{
		$return_array[$list->id] = get_object_vars($list);
	}

	return $return_array;
}
$list_brand = get_list_brand();
function brand($id, $value='name'){global $list_brand; return $list_brand[$id][$value];}









/*
@name: get_brand
@description: kategorileri listelere degiskene atar
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function get_brand($brand_id)
{
	$result = mysqli()->query("SELECT * FROM product_brand WHERE id='$brand_id'");
	return $result->fetch_assoc();
}







/*
@name: is_user_list
@description: belirlenen kullanıcıya ait urun var mi?
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function is_user_list($user_id, $code, $code_type, $brand_id)
{
	$query = mysqli()->query("SELECT * FROM list WHERE
		status='1'
		AND user_id='".active_user('id')."'
		AND code='".$code."'
		AND code_type='".$code_type."'
		AND brand_id='".$brand_id."'
	");


	if($query->num_rows > 0)
	{
		return $query->fetch_assoc();
	}
	else
	{
		return false;
	}
}






/*
@name: get_list
@description: listemele ekleme icin
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function get_list($user_ID_or_array)
{
	if(!is_array($user_ID_or_array))
	{
		return $result = mysqli()->query("SELECT * FROM list WHERE user_id='$user_ID_or_array' AND status='1' ORDER BY id DESC");
	}
	else
	{
		return $result = mysqli()->query("SELECT * FROM list WHERE ".$user_ID_or_array['query']);
	}
}






/*
@name: get_single_list
@description: listemele ekleme icin
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function get_single_list($id)
{
	$id = form_input_control($id);
	$result = mysqli()->query("SELECT * FROM list WHERE id='$id'");
	return $result->fetch_assoc();
}




/*
@name: get_count_list
@description: listemele ekleme icin
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function get_count_list($user_id='')
{
	if($user_id == '')
	{
		$result = mysqli()->query("SELECT * FROM list WHERE status='1'");
	}
	else
	{
		$result = mysqli()->query("SELECT * FROM list WHERE status='1' AND user_id='$user_id'");
	}
	return $result->num_rows;
}



/* ------------------------------------------------------------------------------- */
/*  *****.  LOG
/* ------------------------------------------------------------------------------- */

function html_microtime()
{
	echo '<input type="hidden" name="microtime" id="microtime" value="'.microtime().'">';
}


/*
@name: add_log
@description: log kayitlari icin
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function add_log($array=array())
{
	foreach($array as $name=>$value)
	{
		if(isset($table_name)){$table_name = $table_name.', '.$name;}else{$table_name = $name;}
		if(isset($table_value)){$table_value = $table_value.", '".$value."'";}else{$table_value = "'".$value."'";}
	}

	// datetime ekle
	$table_name = $table_name.', date';
	$table_value = $table_value.",'".date('Y-m-d H:i:s')."'";

	// ip
	$table_name = $table_name.', ip';
	$table_value = $table_value.",'".$_SERVER['REMOTE_ADDR']."'";

	if(!isset($array['user_id']))
	{
		// user_id
		$table_name = $table_name.', user_id';
		$table_value = $table_value.",'".active_user('id')."'";
	}

	if(isset($_POST['microtime']))
	{
		$table_name = $table_name.', microtime';
		$table_value = $table_value.",'".$_POST['microtime']."'";
	}




	mysqli_query(mysqli(), "INSERT INTO _log (".$table_name.") VALUES (".$table_value.")");
	if(mysqli_insert_id(mysqli()) > 0)
	{
		return mysqli_insert_id(mysqli());
	}
	else
	{
		return false;
	}
}

















/* ------------------------------------------------------------------------------- */
/*  *****.  USER
/* ------------------------------------------------------------------------------- */



/*
@name: add_user
@description: bu fonksiyon ile mysql veritabanına veri eklerken güvenlik kontrollerini alıyoruz
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function add_user($array=array())
{
	$array['guid'] = sef_url($array['company_name']);
	foreach($array as $name=>$value)
	{
		if(isset($table_name)){$table_name = $table_name.', '.$name;}else{$table_name = $name;}
		if(isset($table_value)){$table_value = $table_value.", '".$value."'";}else{$table_value = "'".$value."'";}
	}

	mysqli_query(mysqli(), "INSERT INTO users (".$table_name.") VALUES (".$table_value.")");
	if(mysqli_insert_id(mysqli()) > 0)
	{
		$insert_id = mysqli_insert_id(mysqli());
		if(update_user($insert_id, array('guid'=>$insert_id.'-'.$array['guid'])))
		{
			return $insert_id;
		}
	}
	else
	{
		return false;
	}
}


/*
@name: update_user
@description: bu fonksiyon ile veritabanındaki uye bilgilerini guncelliyoruz
@developer: mustafa tanriverdi
@date: 07-12-2015
@update_date: NULL
*/
function update_user($id, $array=array())
{
	foreach($array as $name=>$value)
	{
		if(!isset($update_value)) {$update_value = "$name='$value'"; }
		else
		{
			$update_value = $update_value.", $name='$value'";
		}
	}


	$query = mysqli_query(mysqli(), "UPDATE users SET $update_value WHERE id='$id'");
	echo mysqli_error(mysqli());
	if(mysqli_affected_rows(mysqli()) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}





/*
@name: get_user
@description: db.user tablosunda üye bilgilerini çeker
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function get_user($query_or_ID_or_email_or_phone)
{
	if(is_array($query_or_ID_or_email_or_phone))
	{
		if($result = mysqli()->query("SELECT * FROM users WHERE $query_or_ID_or_email_or_phone"))
		{
		    return $result->fetch_assoc();
		}
		else
		{
			return false;
		}
	}
	else
	{
		$query_or_ID_or_email_or_phone = form_input_control($query_or_ID_or_email_or_phone);
		if($result = mysqli()->query("SELECT * FROM users WHERE id='$query_or_ID_or_email_or_phone'"))
		{
		    return $result->fetch_assoc();
		}
		else
		{
			return false;
		}
	}

}




/*
@name: get_all_user
@description: db.user tablosundaki tüm üyeleri çeker ve diziye aktarır
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function get_all_user()
{
	$return_array;
	$result = mysqli()->query("SELECT * FROM users");
	while($list = $result->fetch_object())
	{
		$return_array[$list->id] = get_object_vars($list);
	}

	return $return_array;
}



/*
@name: get_count_user
@description: toplam uye listesi
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function get_count_user($user_type)
{
	$result = mysqli()->query("SELECT * FROM users WHERE user_type='$user_type'");
	return $result->num_rows;
}




/*
@name: is_login
@description: bir uyenin giris yapip yapmadigi kontrol eder
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function is_login()
{
	if(isset($_SESSION['login_id']))
	{
		return true;
	}
	else
	{
		return false;
	}
}


/*
@name: page_access
@description: sayfanın erişim seviyesini belirtir
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function page_access($value)
{
	if($value == 'corporate')
	{
		if(!is_login()){ header("Location: ".site_url()); exit(); }
		else if(!active_user('user_type') == 'corporate'){ header("Location: ".site_url()); exit(); }
		else {return true;}
	}
}




/*
@name: is_user
@description: db.user tablosunda bir üyenin var olup olmadığını kontrol eder
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function is_user($query)
{
	if($result = mysqli()->query("SELECT * FROM users WHERE $query"))
	{
	    return $result->num_rows;
	    $result->close();
	}
	else
	{
		return false;
	}
}


/*
@name: active_user_ID
@description: aktif üyenin bilgilerini döndürür
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
if(is_login())
{
	$active_user = get_user($_SESSION['login_id']);
}
else
{
	$active_user = false;
}
function active_user($value)
{
	GLOBAL $active_user;
	if($active_user)
	{
		if($value == 'display_name')
		{
			return $active_user['company_name'];
		}
		else
		{
			return $active_user[$value];
		}
	}
	else
	{
		return false;
	}

}
















/* ------------------------------------------------------------------------------- */
/*  *****.  MESSAGE
/* ------------------------------------------------------------------------------- */



/*
@name: add_message
@description: yeni mesaj ekler
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function add_message($out_user_id, $in_user_id, $description, $top_id='0', $array=array())
{
	$message['date'] = date('Y-m-d H:i:s');
	$message['microtime'] = form_input_control($_POST['microtime']);
	$message['top_id'] = $top_id;
	$message['out_user_id'] = $out_user_id;
	$message['in_user_id'] = $in_user_id;
	$message['description'] = $description;
	$message['ip'] = $_SERVER['REMOTE_ADDR'];



	if(isset($array['name_surname'])) { $message['name_surname'] = $array['name_surname']; }
	if(isset($array['phone'])) { $message['phone'] = $array['phone']; }
	if(isset($array['email'])) { $message['email'] = $array['email']; }

	$table_name = insert_array_table($message);
	$table_value = insert_array_value($message);

	if($result = mysqli()->query("INSERT INTO message ($table_name) VALUES ($table_value)"))
	{
		return true;
	}
	else
	{
		return false;
	}

}





/*
@name: get_message
@description: gelen mesajları listeler
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function get_message($message_id)
{
	return $result = mysqli_query(mysqli(), "SELECT * FROM message WHERE id='$message_id'");
}



/*
@name: get_count_message
@description: gelen mesajları listeler
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function get_in_message_list($in_user_id, $reading='0', $array=array())
{
	$query_text = "in_user_id='$in_user_id'";
	if($reading != '')
	{
		$query_text = $query_text.$query_text." AND reading='$reading'";
	}


	return $result = mysqli_query(mysqli(), "SELECT * FROM message WHERE $query_text ORDER BY reading,date DESC LIMIT 1000");
}





/*
@name: get_count_message
@description: yeni mesaj ekler
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date: NULL
*/
function get_count_in_message($in_user_id, $reading='0')
{
	$result = mysqli()->query("SELECT * FROM message WHERE in_user_id='$in_user_id' AND reading='$reading'");
	return $result->num_rows;
}
























/*
@name: mysql_input_control
@description: bu fonksiyon ile mysql veritabanına veri eklerken güvenlik kontrollerini alıyoruz
@developer: mustafa tanriverdi
@date: 11-11-2015
@update_date: NULL
*/
function mysql_input_control($value)
{
	return trim(mysql_real_escape_string($value));
}






/*
@name: sef_url
@description: bu fonksiyon ile isimleri/string verilerini SEF URL formatına çeviriyoruz. Örnek: "Mustafa TANRIVERDİ" => mustafa-tanriverdi
@developer: mustafa tanriverdi
@date: 05-11-2015
@update_date: NULL
*/
function sef_url($url)
{
	 $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',');
	 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','');
	 $url = str_replace($tr,$eng,$url);
	 $url = strtolower($url);
	 $url = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $url);
	 $url = preg_replace('/\s+/', '-', $url);
	 $url = preg_replace('|-+|', '-', $url);
	 $url = preg_replace('/#/', '', $url);
	 $url = str_replace('.', '', $url);
	 $url = trim($url, '-');
	 return $url;
}









/*
@name: get_alert()
@description: bu fonksiyon hata mesajı görünümü verir
@developer: mustafa tanriverdi
@date: 06-12-2015
@update_date:
*/
function get_alert($message='', $title='', $type='danger', $x='true')
{
	?>
	<div class="alert alert-<?php echo $type; ?> alert-dismissible" role="alert">
	  <?php if($x == 'true'): ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php endif; ?>
	  <?php if($title != ''): ?><h3><?php echo $title; ?></h3><?php endif; ?>
	  <?php echo $message; ?>
	</div>
	<?php
}







/*
@name: form_control()
@description: bu fonksiyon ile veritabanı kayıt edilen bilgilerin güvenliğini sağlıyoruz
@developer: mustafa tanriverdi
@date: 05-12-2015
@update_date:
*/
function form_input_control($variable, $array='')
{
	if($array == '')
	{
		return trim(strip_tags(mysqli_real_escape_string(mysqli(), $variable)));
	}
}





/*
@name: convert_gsm()
@description: cep telefonu numaralarını kontrol eder, eger basinda "0" var ise siler
@developer: mustafa tanriverdi
@date: 06-12-2015
@update_date:
*/
function convert_gsm($gsm_number)
{
	$gsm_number = str_replace(' ', '', $gsm_number);
	if(substr($gsm_number, 0,1) == '0')
	{
		$gsm_number = substr($gsm_number, 1);
	}
	return $gsm_number;
}




/*
@name: form_string_control()
@description: bu fonksiyon ile string eksikliklerini kontrol ediyoruz
@developer: mustafa tanriverdi
@date: 05-12-2015
@update_date:
*/
$err_msg = array();
function form_string_control($form_value, $form_text, $controls=array(''))
{
	$continue = true;
	global $err_msg;
	if(!is_array($err_msg)) { $err_msg = array(); }

	// required ile degiskenin var olup olmadibi, yani bos olup olmadigi kontrol ediyoruz
	if(isset($controls['required']))
	{
		if(strlen($form_value) == 0){ array_push($err_msg, $form_text.' alanı boş olamaz.'); }
	}

	// min ile en az karakter sayisini belirtiyoruz
	if(isset($controls['min']))
	{
		if(strlen($form_value) < $controls['min']){ array_push($err_msg, $form_text.' alanı '.$controls['min'].' karakterden az olamaz.'); }
	}

	// min ile en fazla karakter sayisini belirtiyoruz
	if(isset($controls['max']))
	{
		if(strlen($form_value) > $controls['max']){ array_push($err_msg, $form_text.' alanı '.$controls['max'].' karakterden fazla olamaz.'); }
	}

	// min ile en fazla karakter sayisini belirtiyoruz
	if(isset($controls['is_mail']))
	{
		if(!filter_var($form_value, FILTER_VALIDATE_EMAIL)){ array_push($err_msg, $form_text.' alanına lütfen geçerli bir e-posta adresi yazınız.'); }
	}

	if(isset($controls['is_gsm']))
	{
		if(ctype_digit($form_value) and strlen($form_value) < 12 && strlen($form_value) > 9)
		{
			$form_value = convert_gsm($form_value);
			$operator_code = substr($form_value, 0,3);
			$operator_code_list = array('501','505','506','507','551','501','552','553','554','555','559','530','531','532','533','534','535','536','537','538','539','540','541','542','543','544','545','546','547','548','549');
			if(!in_array($operator_code, $operator_code_list))
			{
				array_push($err_msg, $form_text.' alanına girdiğiniz '.$operator_code.' operatör kodu geçersiz.');
			}
		}
		else
		{
			array_push($err_msg, $form_text.' alanındaki telefon numarası hatalı.');
		}
	}



	if($continue == true)
	{
		return $form_value;
	}
	else
	{
		return false;
	}
}


/*
@name: print_alert()
@description: formlardan gelen değerler için ekrana uyarı mesajları basar
@developer: mustafa tanriverdi
@date: 06-12-2015
@update_date:
*/
function print_alert($err_msg, $type='danger', $x='true')
{
	if(is_array($err_msg)):
		foreach($err_msg as $msg):
			get_alert($msg, '', $type, $x);
		endforeach;
	endif;
}


/*
@name: is_form_error()
@description: formda hata var mi?
@developer: mustafa tanriverdi
@date: 06-12-2015
@update_date:
*/
function is_form_error()
{
	global $err_msg;
	if(!empty($err_msg))
	{
		return true;
	}
	else
	{
		return false;
	}
}















/*
@name: currency_to_text()
@description: veritabanında doviz kuru "0,1,2" gibi rakamlarla kayitlidir. Bu fonksiyon "TRY,USD,EUR" gibi birimlere cevirir.
@developer: mustafa tanriverdi
@date: 08-12-2015
@update_date:
*/
function currency_to_text($val, $icon=true)
{
	if($icon == true)
	{
		if($val == 0){ return '<i class="fa fa-try"></i>'; }
		else if($val == 1){ return '<i class="fa fa-usd"></i>'; }
		else if($val == 2){ return '<i class="fa fa-eur"></i>'; }
	}
	else
	{
		if($val == 0){ return 'TRY'; }
		else if($val == 1){ return 'USD'; }
		else if($val == 2){ return 'EUR'; }
	}

}




if(!function_exists("option_selected")) { function option_selected($val_1, $val_2){if($val_1 == $val_2){return 'selected';}else{return false;}} }
if(!function_exists("option_checked")) { function option_checked($val_1, $val_2){if($val_1 == $val_2){return 'checked';}else{return false;}} }







function update_array_string($array)
{
	foreach($array as $name=>$value)
	{
		if(!isset($update_value)) {$update_value = "$name='$value'"; }
		else
		{
			$update_value = $update_value.", $name='$value'";
		}
	}
	return $update_value;
}


function insert_array_table($array)
{
	foreach($array as $name=>$value)
	{
		if(isset($table_name)){$table_name = $table_name.', '.$name;}else{$table_name = $name;}
	}
	return $table_name;
}
function insert_array_value($array)
{
	foreach($array as $name=>$value)
	{
		if(isset($table_value)){$table_value = $table_value.", '".$value."'";}else{$table_value = "'".$value."'";}
	}
	return $table_value;
}



if (!function_exists('mb_ucwords'))
{
	function mb_ucwords($str)
	{
		return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
	}
}






/* kac dakika-saniye-gun-once */
function time_late($date)
{
	$date1 = strtotime(date('Y-m-d H:i:s'));
	$date2 = strtotime($date);
	$day = (($date1-$date2)/3600)/24 ;

	if($day < 1)
	{
		$hours = $day * 24;
		if($hours < 1)
		{
			$second = $hours * 3600;
			if($second < 60)
			{
				return str_replace('', '', $second). ' saniye';
			}
			else
			{
				return str_replace('', '', round($second / 60)). ' dakika';
			}
		}
		else
		{
			return str_replace('', '', round($hours)). ' saat';
		}
	}
	else
	{
		return str_replace('', '', round($day)). ' gün';
	}

}






function echo_memory_usage($val='') {
        echo $mem_usage = memory_get_usage(true);
        exit;

        if ($mem_usage < 1024)
            echo $mem_usage." bytes";
        elseif ($mem_usage < 1048576)
            echo round($mem_usage/1024,2)." kilobytes";
        else
            echo round($mem_usage/1048576,2)." megabytes";

        echo "<br/>";
    }
?>
