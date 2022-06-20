<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_province', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("code",10)->nullable();
            $table->string("name_th",100)->nullable();
            $table->string("name_en",100)->nullable();
            $table->string("zone",100)->nullable();
        });

        // Insert some stuff
        DB::table('tb_province')->insert([
            [ "id" => "1","code" => "10","name_th" => "กรุงเทพมหานคร","name_en" => "Bangkok","zone" => "ภาคกลาง" ],
            [ "id" => "2","code" => "11","name_th" => "สมุทรปราการ","name_en" => "Samut Prakarn","zone" => "ภาคกลาง" ],
            [ "id" => "3","code" => "12","name_th" => "นนทบุรี","name_en" => "Nonthaburi","zone" => "ภาคกลาง" ],
            [ "id" => "4","code" => "13","name_th" => "ปทุมธานี","name_en" => "Pathum Thani","zone" => "ภาคกลาง" ],
            [ "id" => "5","code" => "14","name_th" => "พระนครศรีอยุธยา","name_en" => "Phra Nakhon Si Ayutthaya","zone" => "ภาคกลาง" ],
            [ "id" => "6","code" => "15","name_th" => "อ่างทอง","name_en" => "Ang Thong","zone" => "ภาคกลาง" ],
            [ "id" => "7","code" => "16","name_th" => "ลพบุรี","name_en" => "Lop Buri","zone" => "ภาคกลาง" ],
            [ "id" => "8","code" => "17","name_th" => "สิงห์บุรี","name_en" => "Sing Buri","zone" => "ภาคกลาง" ],
            [ "id" => "9","code" => "18","name_th" => "ชัยนาท","name_en" => "Chai Nat","zone" => "ภาคกลาง" ],
            [ "id" => "10","code" => "19","name_th" => "สระบุรี","name_en" => "Saraburi","zone" => "ภาคกลาง" ],
            [ "id" => "11","code" => "20","name_th" => "ชลบุรี","name_en" => "Chon Buri","zone" => "ภาคตะวันออก" ],
            [ "id" => "12","code" => "21","name_th" => "ระยอง","name_en" => "Rayong","zone" => "ภาคตะวันออก" ],
            [ "id" => "13","code" => "22","name_th" => "จันทบุรี","name_en" => "Chanthaburi","zone" => "ภาคตะวันออก" ],
            [ "id" => "14","code" => "23","name_th" => "ตราด","name_en" => "Trat","zone" => "ภาคตะวันออก" ],
            [ "id" => "15","code" => "24","name_th" => "ฉะเชิงเทรา","name_en" => "Chachoengsao","zone" => "ภาคตะวันออก" ],
            [ "id" => "16","code" => "25","name_th" => "ปราจีนบุรี","name_en" => "Prachin Buri","zone" => "ภาคตะวันออก" ],
            [ "id" => "17","code" => "26","name_th" => "นครนายก","name_en" => "Nakhon Nayok","zone" => "ภาคกลาง" ],
            [ "id" => "18","code" => "27","name_th" => "สระแก้ว","name_en" => "Sa kaeo","zone" => "ภาคตะวันออก" ],
            [ "id" => "19","code" => "30","name_th" => "นครราชสีมา","name_en" => "Nakhon Ratchasima","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "20","code" => "31","name_th" => "บุรีรัมย์","name_en" => "Buri Ram","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "21","code" => "32","name_th" => "สุรินทร์","name_en" => "Surin","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "22","code" => "33","name_th" => "ศรีสะเกษ","name_en" => "Si Sa Ket","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "23","code" => "34","name_th" => "อุบลราชธานี","name_en" => "Ubon Ratchathani","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "24","code" => "35","name_th" => "ยโสธร","name_en" => "Yasothon","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "25","code" => "36","name_th" => "ชัยภูมิ","name_en" => "Chaiyaphum","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "26","code" => "37","name_th" => "อำนาจเจริญ","name_en" => "Amnat Charoen","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "27","code" => "38","name_th" => "บึงกาฬ","name_en" => "Bueng Kan","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "28","code" => "39","name_th" => "หนองบัวลำภู","name_en" => "Nong Bua Lam Phu","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "29","code" => "40","name_th" => "ขอนแก่น","name_en" => "Khon Kaen","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "30","code" => "41","name_th" => "อุดรธานี","name_en" => "Udon Thani","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "31","code" => "42","name_th" => "เลย","name_en" => "Loei","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "32","code" => "43","name_th" => "หนองคาย","name_en" => "Nong Khai","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "33","code" => "44","name_th" => "มหาสารคาม","name_en" => "Maha Sarakham","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "34","code" => "45","name_th" => "ร้อยเอ็ด","name_en" => "Roi Et","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "35","code" => "46","name_th" => "กาฬสินธุ์","name_en" => "Kalasin","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "36","code" => "47","name_th" => "สกลนคร","name_en" => "Sakon Nakhon","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "37","code" => "48","name_th" => "นครพนม","name_en" => "Nakhon Phanom","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "38","code" => "49","name_th" => "มุกดาหาร","name_en" => "Mukdahan","zone" => "ภาคตะวันออกเฉียงเหนือ" ],
            [ "id" => "39","code" => "50","name_th" => "เชียงใหม่","name_en" => "Chiang Mai","zone" => "ภาคเหนือ" ],
            [ "id" => "40","code" => "51","name_th" => "ลำพูน","name_en" => "Lamphun","zone" => "ภาคเหนือ" ],
            [ "id" => "41","code" => "52","name_th" => "ลำปาง","name_en" => "Lampang","zone" => "ภาคเหนือ" ],
            [ "id" => "42","code" => "53","name_th" => "อุตรดิตถ์","name_en" => "Uttaradit","zone" => "ภาคเหนือ" ],
            [ "id" => "43","code" => "54","name_th" => "แพร่","name_en" => "Phrae","zone" => "ภาคเหนือ" ],
            [ "id" => "44","code" => "55","name_th" => "น่าน","name_en" => "Nan","zone" => "ภาคเหนือ" ],
            [ "id" => "45","code" => "56","name_th" => "พะเยา","name_en" => "Phayao","zone" => "ภาคเหนือ" ],
            [ "id" => "46","code" => "57","name_th" => "เชียงราย","name_en" => "Chiang Rai","zone" => "ภาคเหนือ" ],
            [ "id" => "47","code" => "58","name_th" => "แม่ฮ่องสอน","name_en" => "Mae Hong Son","zone" => "ภาคเหนือ" ],
            [ "id" => "48","code" => "60","name_th" => "นครสวรรค์","name_en" => "Nakhon Sawan","zone" => "ภาคกลาง" ],
            [ "id" => "49","code" => "61","name_th" => "อุทัยธานี","name_en" => "Uthai Thani","zone" => "ภาคกลาง" ],
            [ "id" => "50","code" => "62","name_th" => "กำแพงเพชร","name_en" => "Kamphaeng Phet","zone" => "ภาคกลาง" ],
            [ "id" => "51","code" => "63","name_th" => "ตาก","name_en" => "Tak","zone" => "ภาคตะวันตก" ],
            [ "id" => "52","code" => "64","name_th" => "สุโขทัย","name_en" => "Sukhothai","zone" => "ภาคกลาง" ],
            [ "id" => "53","code" => "65","name_th" => "พิษณุโลก","name_en" => "Phitsanulok","zone" => "ภาคกลาง" ],
            [ "id" => "54","code" => "66","name_th" => "พิจิตร","name_en" => "Phichit","zone" => "ภาคกลาง" ],
            [ "id" => "55","code" => "67","name_th" => "เพชรบูรณ์","name_en" => "Phetchabun","zone" => "ภาคกลาง" ],
            [ "id" => "56","code" => "70","name_th" => "ราชบุรี","name_en" => "Ratchaburi","zone" => "ภาคตะวันตก" ],
            [ "id" => "57","code" => "71","name_th" => "กาญจนบุรี","name_en" => "Kanchanaburi","zone" => "ภาคตะวันตก" ],
            [ "id" => "58","code" => "72","name_th" => "สุพรรณบุรี","name_en" => "Suphan Buri","zone" => "ภาคกลาง" ],
            [ "id" => "59","code" => "73","name_th" => "นครปฐม","name_en" => "Nakhon Pathom","zone" => "ภาคกลาง" ],
            [ "id" => "60","code" => "74","name_th" => "สมุทรสาคร","name_en" => "Samut Sakhon","zone" => "ภาคกลาง" ],
            [ "id" => "61","code" => "75","name_th" => "สมุทรสงคราม","name_en" => "Samut Songkhram","zone" => "ภาคกลาง" ],
            [ "id" => "62","code" => "76","name_th" => "เพชรบุรี","name_en" => "Phetchaburi","zone" => "ภาคตะวันตก" ],
            [ "id" => "63","code" => "77","name_th" => "ประจวบคีรีขันธ์","name_en" => "Prachuap Khiri Khan","zone" => "ภาคตะวันตก" ],
            [ "id" => "64","code" => "80","name_th" => "นครศรีธรรมราช","name_en" => "Nakhon Si Thammarat","zone" => "ภาคใต้" ],
            [ "id" => "65","code" => "81","name_th" => "กระบี่","name_en" => "Krabi","zone" => "ภาคใต้" ],
            [ "id" => "66","code" => "82","name_th" => "พังงา","name_en" => "Phang-nga","zone" => "ภาคใต้" ],
            [ "id" => "67","code" => "83","name_th" => "ภูเก็ต","name_en" => "Phuket","zone" => "ภาคใต้" ],
            [ "id" => "68","code" => "84","name_th" => "สุราษฎร์ธานี","name_en" => "Surat Thani","zone" => "ภาคใต้" ],
            [ "id" => "69","code" => "85","name_th" => "ระนอง","name_en" => "Ranong","zone" => "ภาคใต้" ],
            [ "id" => "70","code" => "86","name_th" => "ชุมพร","name_en" => "Chumphon","zone" => "ภาคใต้" ],
            [ "id" => "71","code" => "90","name_th" => "สงขลา","name_en" => "Songkhla","zone" => "ภาคใต้" ],
            [ "id" => "72","code" => "91","name_th" => "สตูล","name_en" => "Satun","zone" => "ภาคใต้" ],
            [ "id" => "73","code" => "92","name_th" => "ตรัง","name_en" => "Trang","zone" => "ภาคใต้" ],
            [ "id" => "74","code" => "93","name_th" => "พัทลุง","name_en" => "Phatthalung","zone" => "ภาคใต้" ],
            [ "id" => "75","code" => "94","name_th" => "ปัตตานี","name_en" => "Pattani","zone" => "ภาคใต้" ],
            [ "id" => "76","code" => "95","name_th" => "ยะลา","name_en" => "Yala","zone" => "ภาคใต้" ],
            [ "id" => "77","code" => "96","name_th" => "นราธิวาส","name_en" => "Narathiwat","zone" => "ภาคใต้" ],
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_province');
    }
}
