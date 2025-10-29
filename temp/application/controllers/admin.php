<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Admin()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model(array('admin_model','google_model'));
		//force_ssl();
	}


	function test_hi() {
		echo BASE_URL;
	}


	function gte_my_details() {


		$db2 = $this->my_namibia_model->connect_my_db();

		$file_path = BASE_URL .'assets/my_na_user_id.csv';

		$this->load->library('csvimport');

		if ($this->csvimport->get_array($file_path)) {

			$csv_array = $this->csvimport->get_array($file_path);

			foreach ($csv_array as $row) {

				$id = trim($row['my_id']);

				//get details
				$query = $db2->query("SELECT * FROM u_client WHERE ID = '".$id."'" ,FALSE);

				$row = $query->row();

				echo $row->ID.' - '.$row->CLIENT_NAME.' - '.$row->CLIENT_SURNAME.' - '.$row->EMAIL.' - '.$row->CLIENT_CELLPHONE.'<br><br>';



			}


		} else {
			

		}


	}





	function push_s3_files($bus_id, $type, $offset, $limit, $y) {

		$this->load->model('s3_model');

		if($type = 'document') {

			$targetDir = 'assets/documents/';


			$sql = $this->db->query("SELECT doc_file FROM documents WHERE bus_id = '".$bus_id."' AND date_format(date_added,'%Y') = " . $y . " LIMIT ".$limit." OFFSET ".$offset." ");

			foreach ($sql->result() as $row) {

					$fileName = base64_encode(file_get_contents(BASE_URL.'assets/documents/'.$row->doc_file));

					//base64_decode($fileName);

					//echo $fileName;

					//echo $targetDir . DIRECTORY_SEPARATOR . $fileName;

					echo $row->doc_file;


					if($this->s3_model->upload_s3($targetDir . $fileName)){

						//$out .= ' >> Image Uploaded to S3! ';

						echo $row->doc_file;

					}else{

						//$out .= ' << Image NOT Uploaded to S3! ';

					}

			}

		}

	}



	function email($email_id){

		$this->load->model('email_model');

		$email = $this->email_model->show_newsletter_email($email_id);

		echo $email;
	}


	function get_agency_agents_list() {

		$this->load->model('my_namibia_model');

		$subs = $this->db->query("SELECT agent_id, name FROM property_agencies WHERE bus_id = '2551'");

		foreach ($subs->result() as $row) {

			$db2 = $this->my_namibia_model->connect_my_db();
			$query = $db2->query("SELECT B.CLIENT_NAME, B.CLIENT_SURNAME, B.CLIENT_EMAIL FROM i_client_business AS A LEFT JOIN u_client AS B ON A.CLIENT_ID = B.ID WHERE A.BUSINESS_ID = '".$row->agent_id."'");

			foreach ($query->result() as $row2) {

				echo $row->name.' - '.$row2->CLIENT_NAME.' '.$row2->CLIENT_SURNAME.' '.$row2->CLIENT_EMAIL.'<br>';

			}

			echo '-----------------<br>';



		}


	}


	function get_promotion_winners() {

		$subs = $this->db->query("SELECT * FROM images AS A  WHERE A.gal_id = '2276'");

		foreach ($subs->result() as $row) {


			$subs2 = $this->db->query("SELECT * FROM promotion_votes  WHERE type_id = '".$row->img_id."'");

			echo $row->img_id.'<h2>'.$row->title.'</h2><img src="'.S3_URL.'assets/images/' . $row->img_file.'" style="width:200px"><br><h4><strong>Votes: </strong>'.$subs2->num_rows().'</h4>
			<hr>
			';

		}

	}



	/*function upload_vw_stocks() {

		$subs = $this->db->query("SELECT stock_id FROM product_stock WHERE bus_id = '2666'");

		foreach ($subs->result() as $row) {

			$data = array(
				'bus_id'=> '2666',
				'branch_id'=> '2' ,
				'type_id'=> $row->stock_id,
				'type'=> 'stock',
				'branch'=> 'Windhoek Branch'
			);

			$this->db->insert('branch_content_int', $data);


		}


	}



	function add_subscriber_types() {

		$subs = $this->db->query("SELECT subscriber_id FROM subscribers WHERE bus_id = '10591'");

		if($subs->result()) {

			foreach ($subs->result() as $row) {

				$data = array(
					'bus_id'=> '10591',
					'subscriber_id'=> $row->subscriber_id ,
					'type_id'=> '163',
					'type_name'=> 'General'
				);

				$this->db->insert('subscriber_type_int', $data);

			}

		}

	}


	function update_nmc() {


		$file_path = BASE_URL .'assets/nmc_members.csv';

		$this->load->library('csvimport');

		if ($this->csvimport->get_array($file_path)) {

			$csv_array = $this->csvimport->get_array($file_path);

			foreach ($csv_array as $row) {

				$mem_no = trim($row['mem_no']);
				$dob = trim($row['dob']);

				$dateofbirth = str_replace("/","-",$dob);

				$insertdata = array(
					'dob'=> $dateofbirth
				);

				$this->db->where('mem_no', $mem_no);
				$this->db->update('subscribers', $insertdata);

			}


		} else {


		}


	}



	function import_class_csv() {


		$file_path = BASE_URL .'assets/ncci_class_csv.csv';

		$this->load->library('csvimport');

		if ($this->csvimport->get_array($file_path)) {

			$csv_array = $this->csvimport->get_array($file_path);

			foreach ($csv_array as $row) {

				$title = trim($row['title']);
				$code = trim($row['code']);
				$parent= trim($row['parent']);

				$insertdata = array(
					'bus_id'=> '5503' ,
					'title'=> $title,
					'code'=> $code,
					'parent'=> $parent

				);

				$this->db->insert('business_classifications', $insertdata);

			}


		} else {
			

		}


	}



	function import_csv() {

		//$file_data = $this->upload->data();
		$file_path = BASE_URL .'assets/nf_subscribers.csv';

		$this->load->library('csvimport');


		if ($this->csvimport->get_array($file_path)) {



			$csv_array = $this->csvimport->get_array($file_path);

			$i=1;

			foreach ($csv_array as $row) {


				//$name = trim($row['name']);
				$email = trim($row['email']);
				$type = 'General';
				//$activation_code = trim($row['activation_code']);
				//$datetime = trim($row['datetime']);
				//$mem_no = trim($row['mem_no']);
				//$password = trim($row['password']);

				if($type == 'General') { $tid = 164; }

				//CHECK IF USER EXISTS
				$query = $this->db->query("SELECT subscriber_id FROM subscribers WHERE bus_id = '11913' AND email = '".$email."'", FALSE);

				if($query->result()){

				} else {

					$insertdata = array(
						'bus_id'=> '11913' ,
						'email'=> $email

					);

					$this->db->insert('subscribers', $insertdata);
					$insert_id = $this->db->insert_id();

					$insertdata2 = array(
						'bus_id'=> '11913' ,
						'subscriber_id'=> $insert_id,
						'type_id'=> $tid,
						'type_name'=> $type

					);
					$this->db->insert('subscriber_type_int', $insertdata2);

					$i++;

				}

				echo $email;

			}


		} else {

			echo 'bye';

		}

		echo $i;

	}




	function import_mani_csv() {

		//$file_data = $this->upload->data();
		$file_path = BASE_URL .'assets/mani_subscribers.csv';

		$this->load->library('csvimport');


		if ($this->csvimport->get_array($file_path)) {



			$csv_array = $this->csvimport->get_array($file_path);
			$i=1;
			foreach ($csv_array as $row) {

				$name = trim($row['name']);
				$sname = trim($row['sname']);
				$company = trim($row['company']);
				$type = trim($row['type']);
				$email = trim($row['email']);

				if($type == 'All') { $tid = 83; }

				//CHECK IF USER EXISTS
				$query = $this->db->query("SELECT subscriber_id FROM subscribers WHERE bus_id = '10591' AND email = '".$email."'", FALSE);

				if($query->result()){

				} else {

					$insertdata = array(
						'bus_id'=> '10591' ,
						'name'=> $name,
						'sname'=> $sname,
						'company'=> $company,
						'type'=> $type,
						'email'=> $email

					);
					$this->db->insert('subscribers', $insertdata);
					$insert_id = $this->db->insert_id();

					$insertdata2 = array(
						'bus_id'=> '10591' ,
						'subscriber_id'=> $insert_id,
						'type_id'=> $tid,
						'type_name'=> $type

					);
					$this->db->insert('subscriber_type_int', $insertdata2);
					$i++;
				}



			}


		} else {

			echo 'bye';

		}

		echo $i;

	}


	function upload_fbwp_members() {

		$members = '
		abedtc@yahoo.co.uk; andreaspaul.namibia@gmail.com; anton@nexusgroup.com.na; alida@smitjoineries.com; amor@iway.na; apnaada@gmail.com; amounton@ogilvy.com.na; antonio@rivoli.com.na; adejager@mtc.com.na; albertynmadeleen@gmail.com; anny@ogilvy.com.na; ags1@mweb.com.na; anel@rfsol.com.na; andrevan@mweb.com.na; acc.calculus@iway.na; abius@optimediacc.com; anjoclothing@facebook.com; adele@woodcreate.org; adrikotze@iway.na; anel@shoprite.co.za; albertpretorius@iway.na; alnasor1@gmail.com; anlo.vangeems@facebook.com; autoafrica@internet.com.na; ashikotot@ra.org.na; accounts@namibia-safaris.com; annetjie@ellisnam.com; altam@wkh-law.com; Andreas.Potgieter@lorentzangula.com.na; abri@iway.na; admin@triplus-nam.com; abe@whk-law.com; alet@mbdklaw.com; achinguenhane@wis.edu.na; angombe@wis.edu.na; admin@oshpharm.com; amerik.haer@kuehne-nagel.com; admtnx@gmail.com; aWellmann@fnbnamibia.com.na; admin@fbhgroup.net; anelle@mweb.com.na; agsfila@iway.na; anel@xlthetravelprofessionals.com; deco@mweb.com.na; aocallaghan@rfsol.com.na; AnjeZeise@joggie.com.na; pakit@iafrica.com.na; alida@smartjoineries.com; adrikotze@iway.na; acaciaz@penta-net.co.za; abedtc@yahoo.co.uk; admin@fbhgroup.net; BotesR@bankwindhoek.com.na; bermarker1@corporateguarantee.com; besbier@iway.na; bennie@wimpy-namibia.com; berengeregautier@me.com; bacad.mandy@gmail.com; BGreen@fnbnamibia.com.na; BarendOO@Nedbank.com.na; barr.kwame1960@gmail.com; bronkie7@gmail.com; betsie.jackes@gmail.com; BezuidenhoutF@bankwindhoek.com.na; Brittany.junius@yahoo.com; betven@iway.na; burgert@Otjimun.org.na; beate224@gmail.com; berry@docvcr.co.za; bezuidenhoutroger@gmail.com; buysfam@iway.na; BrandN@marsh-afrs.com; chkotze@mweb.com.na; Carien.Lacock@wce.com.a; coetzee.maud@gmail.com; ChristaO@Nedbank.com.na; conrad@africanwanderer.com; cdempsey@cirrus-finance.xom; chris@fqp.com.na; Charleen@fqp.com.na; claims.pib@iway.na; cara@iway.na; cheimstadt@wis.edu.na; Charlene@internet.com.na; Candia@iway.na; chrisna@mudgetrust.com; cphorn@mweb.com.na; CasparyR@cih.com.na; christa@drdlaw.pro; caroline.handl@gmail.com; chkotze@afol.com.na; christa.jurgens@pkf.co.na; chantell001@gmail.com; Cobus.Bruwer@za.sabmiller.com; CoertzenA@cih.com.na; danie@blocdesignstudio.com; DaleDE@nedbank.com.na; daleen@qaconsultingnamibia.com; dangote@iway.na; dawie@dmrail.com; dirk@bartschnam.com; danste@africaonline.com.na; dederick@auctiondynamix.com; derheimwerker@iway.na; du-macha@mweb.co.za; dsamkoita@gmail.com; dvanrooi@fnbnamibia.com; david@bredamc.com; dhite@mweb.com.na; dimol@iway.na; dress_up@adessus.com; durenco@wiese4u.com; danste@iafrica.com.na; deco@mweb.com.na; deonfengelbrecht@gmail.com; danica@africanmonarch.com.na; Denis.Maxwell@denchi.com.na; dvdlinde@bokomonamibia.co.za; diergaardtj@fnbnamibia.com.na; dawid@eps.com.na; dina01madi@gmail.com; dutoits@bravuranamibia.com; exigegroup@gmail.com; erentiat@gmail.com; esteswarts@gmail.com; elmi@namslab.com; Ecollard@iway.na; elmarie.kloppers@rcc.com.na; ellen.prinsloo@me.com; EsterhuysenJ@cih.com.na; emnanuses@fnbnamibia.com.na; EDavids@advance.com.na; elizma@protennisacademy.com.na; Elmarie.Greenaway@axa-im.com; evermaak@iway.na; elizevnwk@gmail.com; ensav@yahoo.com; ebyb@kruispad.com; estine@iway.na; elmarie.lewi@kuehne-nagel.com; eschutz@iway.na; ebrand@africaonline.com.na; ewaldforum@hotmail.com; ewald@africaonline.com; et@africaonline.com; eben@wimpy-namibia.com; esta@auctiondynamix.com; fouandre@gmail.com; ffosec@iway.na; Freddie@finsure.net; finacc.calculus@gmail.com; fbeukes@wis.edu.na; francios.swart@yahoo.com; florisbergh@iway.na; frametique@mtcmobile.com.na; frauke@new-media-consult.com; franbiew@webmail.com; faren@property.com.na; fourie@namibinet.com; francois.marietta@gmail.com; gerhard@finsure.net; geldenhuysA@bankwindhoek.com.na; gkwim@yahoo.com; gerhardass@sanlam4U.com.na; gbpmybs@gmail.com; Gpretorius@NamibMills.com.na; gateway@mweb.com.na; glass@mtcmobile.na; gdacc@iway.na; greens@mweb.com.na; gerhardn@iafrica.com.na; gys@aldesnamibia.com; gerome@africaonline.com.na; GertruidaSA@Nedbank.com.na; gisela.henn@gmail.com; general@eonproperty.com; greeff@iway.na; glcronje@iway.na; hennie@republikein.com.na; hildie@iway.na; hermana30@gmail.com; hfernandes.na@alliancemedia.com; hesterbergh@gmail.com; hjbruyns@gmail.com; hendrikgrove@iway.na; hantiejansen@mweb.com.na; henryelmine@mweb.com.na; hannelietruter@facebook.com; hendrik.venter@za.ey.com; hanne.cervino@gmail.com; heathercraemer@gmail.com; hellereck@web.de; henco@gsfa.com.na; henco@citysand.com.na; hx1@officeconoix.com; harpercharmaine1@gmail.com; herbert.vanniekerk@na.g4s.com; harryjou@tiscali.co.za; htjozongoro@fnbnamibia.com.na; henjen@iway.na; hbrisley@iway.na; hegja@yahoo.co.uk; herselmanw@hhqs.com.na; househopping@mweb.com.na; hvdwalt@roshcare.com; hendrink.smith@yahoo.com; hrubbert@wis.edu.na; hedebruin@deloitte.co.za; izaan@mtarch-inc.com; idc@idc.com.na; info@finkensteinmv.com; inge@ellisnam.com; igaoes@obeserver.com.na; ictech@iway.na; igna@iway.na; illona@propcor.net; info@strcuisine.com; irpauw@gmail.com; info@meastro.com.na; injector@iway.na; info@wika.com.na; info@mountainmanor.co.za; inakorner19@gmail.com; jnorval@mrc.com.na; jandre@aucornamibia.com; jenny@xlthetravelprofessionals.com; Johan.LeRoux2@PTBatteries.co.za; jarcher@iway.na; jki@iway.na; jjjcamm@gmail.com;; Johan.Kritzinger@trafigura.com; johanr@windhoekgymnasium.com; juliaengels1@gmail.com; jaco@wiese4u.com; jbruwer@wis.edu.na; jblofty@gmail.com; jolinedeklerk@yahoo.co.uk; jwbeukes@gmail.com; joanepot@yahoo.com; jretief@iway.na; jdeklerk@iway.na; jewbox@iway.na; jpdunasafari@iway.na; jaco@ppnam.com; johan.vonwielligh@facebook.com; jay@docvcr.co.za; Julie@esinamibia.com; john@arebbusch.com; jacques@kosmos.com.na; Jacques@styleg.com.na; JacobsL@bankwindhoek.com.na; jacquesvz@agra.com.na; jeweller@diamondnamibia.com; jfhoeseb@yahoo.com; jp@bigsky-namibia.com; jackieburton@iway.na; Jansen-VisagieA@bankwindhoek.com.na; jolenec.nell@gmail.com; jmgous@gmail.com; jrcl@telkomsa.net; julie@iway.na; jomari.npls@gmail.com; Karen.vanderMerwe@standardbank.com.na; kola@exactnamibia.com; kschrywer@gmail.com; KapinganaG@bankwindhoek.com.na; KarlKI@nedbank.com.na; koitafrans@yahoo.com; kotzegp@iway.na; kobus.smit@live.co.za; Kwsproule@aol.com; Kobie.lofty-eaton@fnbnamibia.com.na; Karen-Theunissen@za.ey.com; kobus@i3actuaries.com; Karin.whk@weylandt.com.na; kobus.jnr@gmail.com; kassiel@nedbank.com.na; kirbynam@gmail.com; koos@seenalegal.com; karinvdlinde7@gmail.com; kuffnerr@iway.na; Karin@windhoekgymnasium.com; karin.heydenrych@gmail.com; laracharnock@gmail.com; lyndon@fblcapital.com; linus.malherbe@gmail.com; LourensE@bankwindhoek.com.na; linda@fqp.com.na; leonivonwielliigh@gmail.com; lucymay.lubrani@ogilvy.com.na; leone@drdlaw.pro; loftye@mtcmobile.com.na; liebenbergjc@gmail.com; MichelleneWi@Nedbank.com.na; marold@wkh-law.com; M.nell@mtechelectrical.com; mrenardhome@gmail.com; magda@nammic.com.na; MTalbot@fnb.co.za; mle@iway.na; mynardts@westair.com.na; mivocu@mtcmobile.com.na; marynprins@yahoo.com; MarievanZ@Nedbank.com.na; maritzpj@iway.na; management@eonproperty.com; mark@rfson.com.na; Marietta.hettasch@glenrandmib.com; marlienslin@gmail.com; mellabotha@gmail.com; MartinK@bankwindhoek.com.na; marizagous@gmail.com; marianvz@afol.com.na; maren@mbdklaw.com; marisav@iway.na; margot@iway.na; MulenamasweS@bankwindhoek.com.na; manfredhum@afol.com.na; mduplooy@wis.edu.na; miragem10@gmail.com; microzones@hotmail.com; mark@betcretenam.com; michael@advancecarhire.com; mari@pwv.com.na; Monica.Pienaar@jhi.co.za; merie@burmeister.com.na; magda@barnardmutua.com; Mellany.Engelbrecht@Momentum.com.na; MVictor@meatco.com.na; Marlene56@iway.na; mmuuondjo@yahoo.com; mliebenberg@iway.na; Manus.grobler@standardbank.com.na; md@ogilvy.com.na; mmalan@iway.na; manja@siyanda.com.na; madeleinesps@gmail.com; man.swk@vegimark.com; michelle@corporateconnections.com.na; mvisser@iway.na; mrensia@yahoo.com; Marilize.Engelbrecht@nampower.com.na; mchakira@gmail.com; nevadia@wkh-law.com; nadineheberling@gmail.com; nicolaase@letshego.com; nelfamily@finsure.net; nchatak@yahoo.com; nicolaase@letshegonamibia.com; neelsscholtz@gmail.com; namibfun@iway.na; nambetonacc@africaonline.com.na; ngah@wis.edu.na; ngkoos@africaonline.com.na; NDobberstein@fnbnamibia.com; natasja@namedia-nam.com; nomonde@coricraft.co.za; nieldp@mweb.com.na; nchivure@wis.edu.na; naude@wkh-law.com; nandetate@gmail.com; nell.fustec@gmail.com; naemymeke@yahoo.com; nelao2021@gmail.com; nielr@iway.na; neels@siyanda.com.na; natalie@mecernamibia.com; nam00256@mweb.com.na; nadja@elisenheim.com; niekerk@iafrica.com.na; natalie.apkf@gmail.com; ollescarmen@gmail.com; ophelia.netta@namdeb.com; ona@advance.com.na; onbeatnam@gmail.com; onbeatmusic.cc@gmail.com; poenie@wkh-law.com; paolo.cervino@gmail.com; pakit@iafrica.com.na; pmalan@shoprite.co.za; Petra.Laaser@olfitra.com.na; petrik@mweb.com.na; pjtromp@nictus.com.na; pvnadmin@iway.na; pmwild@iway.na; pieter@seal.com.na; pretorius@metjeziegler.com; pz@iway.na; pcruz@sbif.cl; pieter@pointbreak.co.za; paul.oosthuizen@officeconomix.com; priscilla.tlh@gmail.com; pwf@iway.na; pierre@investmentcarscc.com; petrie.theron@iway.na; pludwig@iway.na; PretoriusDe@bankwindhoek.com.na; production@spice.com.na; pswart@shoprite.co.za; pietb@afrideca.com.na; pieter@highwaytt.com.na; patmarcc@gmail.com; plastics@duminy.com; ptleriche@gmail.com; pwilliams@iway.na; pieter.steenkamp@telkomsa.net; Phortune.Tjivikua@olfitra.com.na; peet@afrideca.com.na; phortunetjivikua@gmail.com; patrickdandakou1@gmail.com; pose1122@gmail.com; perfectglass@iway.na; Patterson.Tjipueja@za.ey.com; pets@iway.na; rstrauss@iway.na; rudolfg@afol.com.na; rw@rudo.co.za; retha@smithjoineries.com; ronel@housefindernam.com; realestate@eonproperty.com; robert@afol.com.na; robert@aps.com.na; riaanke@nedbank.com; rkrugel@iway.na; ritandua@gmail.com; Randy.Slabbert@standardbank.com.na; roneldt@iway.na; retha@smitjoiners.com; rential@letshego.com; ralph@wkh-law.com; reni@mweb.com.na; RVermeulen2@oldmutual.com; rudowinckler@me.com; rolandvg@gmail.com; rhona@k7.com.na; rudolfn@iway.na; r.neethling@pupkewitz.com; rudowinck@gmail.com; renee.roquedasilva@jhi.co.za; Riaan.Schwartz@ndc.org.na; rene@wiese4u.com; rcloete@mtc.com.na; redmantrans@mtcmobile.com.na; rosew@iway.na; richardean.zhong77@gmail.com; rosaj@iway.na; sickel@iway.na; StanderB@bankwindhoek.com.na; snsaayman@iway.na; stoffel45@hotmail.com; santaclara@iway.na; stoffel@myself.com; safmed@iway.na; sheila@iway.na; swktotal@iway.na; spienaar@mtcmobile.com.na; sarah.bisanda-toga@na.pwc.com; Simon.Steyn@lbcommserv.com; stefan@snowballstudio.com; Stefan.Saayman@roshskor.com.na; solucia@afol.com.na; steffi1dressel@gmail.com; swjbotha@iway.na; stefan.hugo@na.pwc.com; sonjanel@iway.na; spienaar@grintek.com; swartax@state.gov; seimonsm@gmail.com; studio1@iway.na; sarah.bisanda-toga@na.pwc.com; suzettek@mtcmobile.com.na; suzette.mouton@gmail.com; Santa.Vanzyl@swakopuranium.com.na; Shaun.Ward@trafigura.com; saskiah@mweb.com.na; SaalL@bankwindhoek.com.na; sariettav@yahoo.com; spawnmondor@yahoo.co.uk; sales@vwprojects.com.na; Simone@wkh-law.com; Sanna.vanderByl@standardbank.com.na; Sa.Engel@web.de; sszross@gmail.com; spswakop@iway.na; stephan.van-rooyen@na.pwc.com; sunda@mobilesunda.com; stefan@oryxprop.com.na; smmatengu@gmail.com; sls@iway.na; Samueltrust03@gmail.com; Silveriamaritshane@gmail.com; sybrand@housefindernam.com; svanderbergh@shoprite.co.za; Trysie.Kannemeyer@pumaenergy.com.na; trustees@africaonline.com.na; tiaan@medscheme.com.na; tslabbert@fnbnamibia.com.na; tertius.stears@sanlam.com.na; theron@pdtheronlaw.com; tddup@iway.na; twizza@mtcmobile.com.na; touchos@iafrica.com.na; tania@bathplace.com.na; thresia@bargainbooks.co.za; truts@africaonline.com.na; TrulaWi@Nedbank.com.na; tcoertze@gmail.com; thanisebhh@gmail.com; Tstrong@indongogroup.com; tddiup@iway.na; tneldner@englinglaw.com.na; tokelosred@hotmail.com; Trekkerspoorslang@gmail.com; Tlindji@fnbnamibia.com.na; ujgollwitzer@gmail.com; utekrause2@gmx.de; utopia@africaonline.com.na; uschi@namibia-1on1.com; vintage@iway.na; victor.convic@iway.na; vermeulenpilot@yahoo.com; vzlynette@gmail.com; vfreeman@fnbnamibia.com.na; verdi@iway.na; vanwykleon@hotmail.com; vaughbroux@iafrica.com; ViljoenF@bankwindhoek.com.na; VincentDI@Nedbank.com.na; Villa25cc@afol.com.na; VanZylJ@bankwindhoek.com.na; vanderWesthuizenJo@bankwindhoek.com.na; vanzylriaan2@gmail.com; vikus777@yahoo.com; VKaramatha@fnbnamibia.com.na; vwbc2@africaonline.com.na; valuations@namibnet.com; vastrap@mweb.com.na; ViljoenL@bankwindhoek.com.na; vibrantz@iway.na; williendupreez@hotmail.com; Wanda@angulacoleman.com; walenga@omalaeti.com; willien@elisenheim.com; wannenmacher.nam@gmail.com; workshop@capefire.co.za; wvdmerwe@namibmills.com.na; wildersvaluations@gmail.com; wilma.docweber@mweb.com.na; wiltrudpatzner@gmail.com; w.snyman@mweb.com.na; wap@wap.edu.na; walt@iway.na; willemvrey@gmail.com; WeissB@bankwindhoek.com.na; wahl@iway.na; willfour40@icloud.com; wilfour40@icould.com; wiebke@africantracks.com; willie@nammic.com.na; wiid@agrimol.co.za; xpsgm@thesignshop.com.na; xpsxa@thesignshop.com.na; ystander@wis.edu.na; yvonne.vandermerwe@pamgolding.com.na; yssel@wkh-law.com; yolandi.hartslief@stefstocks.com; yvonne@casarealestate.net; yvetteku@nedbank.com.na; yoav@lknam.com; zanlumor@mweb.com.na
	';

		$exp_members = explode(';', $members);
		$i=1;
		foreach($exp_members as $mem) {

			$mem = trim($mem);

			//Check if email exist
			$test = $this->db->where('email', $mem);
			$test = $this->db->where('bus_id', '9009');
			$test = $this->db->get('subscribers');

			if($test->result()){

			} else {
				$insertdata = array(
					'bus_id'=> '9009' ,
					'email'=> $mem

				);
				$this->db->insert('subscribers', $insertdata);
				$i++;
			}

		}
		echo $i;
	}*/


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		redirect(site_url('/').'admin/home','refresh');	
	}

	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function clean_cache()
	{

		if($this->session->userdata('caching') == 'Y'){

			$url = $this->session->userdata('url');

			$out = file_get_contents(prep_url($url).'/main/clean_cache/');
			$this->session->set_flashdata('msg','Cache cleaned successfully');
		}
		$redirect = $this->input->get('redirect');
		redirect($redirect,'refresh');
	}



	public function transfer_types() {

		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->query("SELECT a.bus_id AS bid, a.type AS typ, a.subscriber_id AS sid,b.sub_type_id AS stid FROM subscribers AS a
								   
								   INNER JOIN subscriber_type AS b on a.type = b.type
								   
								   ", FALSE);
		if($query->result()){
			
			foreach($query->result() as $row){
				
				$insertdata = array(
				  'bus_id'=> $row->bid,
				  'subscriber_id'=> $row->sid,
				  'type_id'=> $row->stid,
				  'type_name'=> $row->typ
				);					
					

				$this->db->insert('subscriber_type_int', $insertdata);				
				
				
			}		
		}
	}	
	
	
	
	public function get_my_business_name($data)
	{
		$this->load->model('my_namibia_model');
		echo $this->my_namibia_model->get_business_name($data);	
		
	}
	
	public function add_my_business_name($page_id, $my_id)
	{
		//$this->load->model('my_namibia_model');
		//$db2 = $this->my_namibia_model->connect_my_db();
		
		  $my_id = trim($my_id);	
			
		  $this->load->model('my_namibia_model');
		  $this->my_namibia_model->add_business_do($page_id, $my_id);
		
		
		echo '<div class="alert alert-success">Business has been linked</div>';

		
	}	

	public function reload_businesses($page_id)
	{
		$this->load->model('my_namibia_model');
		$this->my_namibia_model->get_selected_businesses($page_id);
		
	}	
	
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN Update
	//++++++++++++++++++++++++++
	public function my_namibia()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$data = $this->my_namibia_model->get_info();
			$this->load->view('admin/my_namibia', $data);						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
	

	
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN Update
	//++++++++++++++++++++++++++
	public function update_my_namibia_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->my_namibia_model->update_my_namibia_do();						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN ADD LOGO
	//++++++++++++++++++++++++++
	public function add_logo_ajax()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->my_namibia_model->add_logo_ajax();						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
	
	
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN Update
	//++++++++++++++++++++++++++
	public function get_language_page($language, $id)
	{
		if($this->session->userdata('admin_id')){
			

			$this->admin_model->get_language_page($language, $id);
				
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}	
	
	
	
	//+++++++++++++++++++++++++++
	//ATTACH DOWNLOADS
	//++++++++++++++++++++++++++
	public function add_downloads()

	{
		//var_dump($this->input->post());
		$bus_id = $this->session->userdata('bus_id');
		
		if($this->input->post('downloads')){
			
			
			//CLEAN TABEL
			$query1 = $this->db->where('type', $this->input->post('type'));
			$query1 = $this->db->where('type_id', $this->input->post('type_id'));
			$query1 = $this->db->get('content');
			if($query1->result()){
				
				foreach($query1->result() as $row){
					
					foreach($this->input->post('downloads') as $doc_id){
						
						if($row->doc_id == $doc_id){
							
						//DELETE	
						}else{
							
							$this->db->where('content_id', $row->content_id);
							$this->db->delete('content');
						}
						
					}
					
				}
				
			}
			
			
			//DO INSERT
			foreach($this->input->post('downloads') as $doc_id){
				
				//TEST EXISTING
				$query2 = $this->db->where('type', $this->input->post('type'));
				$query2 = $this->db->where('type_id', $this->input->post('type_id'));
				$query2 = $this->db->where('doc_id', $doc_id);
				$query2 = $this->db->get('content');
				if($query2->result()){
				
	
				}else{
					$data['type'] = $this->input->post('type');
					$data['type_id'] = $this->input->post('type_id');
					$data['bus_id'] = $bus_id;
					$data['doc_id'] = $doc_id;
					
					$this->db->insert('content', $data); 	
				}
			}
				
			
		} else {

			$type_id = $this->input->post('type_id');
			$type = $this->input->post('type');

			$this->db->query("DELETE FROM content WHERE type_id = '".$type_id."' AND type = '".$type."' AND doc_id != '0'", FALSE);

		}
		
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//ATTACH DOWNLOADS
	//++++++++++++++++++++++++++
	public function add_page_sidebars()
	{
		//var_dump($this->input->post());
		$bus_id = $this->session->userdata('bus_id');
		
		if($this->input->post('sidebars')){
			
			
			//CLEAN TABEL
			$query1 = $this->db->where('type', $this->input->post('type'));
			$query1 = $this->db->where('type_id', $this->input->post('type_id'));
			$query1 = $this->db->get('content');
			if($query1->result()){
				
				foreach($query1->result() as $row){
					
					foreach($this->input->post('sidebars') as $sidebar_id){
						
						if($row->sidebar_id == $sidebar_id){						
							
							
							
						//DELETE	
						}else{
							
							
							
							$this->db->where('content_id', $row->content_id);
							$this->db->delete('content');
						}
						
					}
					
				}
				
			}
			
			
			//DO INSERT
			foreach($this->input->post('sidebars') as $sidebar_id){
				
				//TEST EXISTING
				$query2 = $this->db->where('type', $this->input->post('type'));
				$query2 = $this->db->where('type_id', $this->input->post('type_id'));
				$query2 = $this->db->where('sidebar_id', $sidebar_id);
				$query2 = $this->db->get('content');
				if($query2->result()){
				
	
				}else{
					$data['type'] = $this->input->post('type');
					$data['type_id'] = $this->input->post('type_id');
					$data['bus_id'] = $bus_id;
					$data['sidebar_id'] = $sidebar_id;
					
					$this->db->insert('content', $data); 	
				}
			}
				
			
		} else {
			
			$query1 = $this->db->where('bus_id', $bus_id);
			$query1 = $this->db->where('type', $this->input->post('type'));
			$query1 = $this->db->where('type_id', $this->input->post('type_id'));
			$this->db->delete('content');

			
		}
		
		
	}	
	
	
	
	
		
	public function home()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/home');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//GA STATS
	//++++++++++++++++++++++++++
	public function ajax_load_home($start = '', $end = '')
	{
		$this->google_model->load_overview($start , $end );
		
	}
	//+++++++++++++++++++++++++++
	//GA STATS
	//++++++++++++++++++++++++++
	public function ajax_load_home2($start = '', $end = '')
	{
		 $this->google_model->traffic_graph($start , $end);
			
		 $this->google_model->organic_keywords($start , $end);
		
	}


	//+++++++++++++++++++++++++++
	//GA STATS
	//++++++++++++++++++++++++++
	public function location_map($start = '', $end = '')
	{
		$this->google_model->location_map($start , $end);



	}

	public function ajax_load_calendar()
	{
		$this->load->model('calendar_model');
		$this->load->view('admin/inc/calendar_inc');
		
	}
	
	public function ajax_load_bookings()
	{
		$this->load->model('calendar_model');
		$this->load->view('admin/bookings/calendar_inc');
		
	}
	
	//+++++++++++++++++++++++++++
	//MENU BUILDER
	//++++++++++++++++++++++++++

	public function menu()
	{
		if($this->session->userdata('admin_id')){
			
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->get('menus');
			
			if($query->result()){
				
				$row = $query->row_array();
				$menu['menu'] = $row['menu'];
				
				
			}else{
				
				$menu['menu'] = ''; 
				
			}
			
			$this->load->view('admin/menu', $menu);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//update new menu
	//++++++++++++++++++++++++++

	public function update_menu($id)
	{
		if($this->session->userdata('admin_id')){

			$query = $this->db->where('menu_id', $id);
			$query = $this->db->get('menus');

			if($query->result()){

				$row = $query->row_array();
				$menu['menu'] = $row['menu'];


			}else{

				$row['menu'] = '';
				$row['menu_id'] = 0;

			}
			$menu['menu_id'] = $id;
			$this->load->view('admin/menu_update', $row);

		}else{

			$this->load->view('admin/login');

		}


	}
	//+++++++++++++++++++++++++++
	//SHOW MENU
	//++++++++++++++++++++++++++

	public function show_menu($menu)
	{
		
		$this->admin_model->show_menu($menu);
		
		
	}

	//+++++++++++++++++++++++++++
	//Updte Menu
	//++++++++++++++++++++++++++
	public function update_menu_do()
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->update_menu_do();

		}else{

			redirect(site_url('/').'/admin/logout/','refresh');

		}
	}

	//+++++++++++++++++++++++++++
	//UNSUBSCRIBE
	//++++++++++++++++++++++++++
	public function add_menu_link()
	{

		if($this->session->userdata('admin_id')){

			$d['bus_id'] = $this->session->userdata('bus_id');
			if($title = $this->input->get('title')){

				if($url = $this->input->get('url')){

					$d['title'] = $title;
					$d['url'] = $url;


				}else{

					$d['title'] = $title;
				}
				$this->db->insert('links', $d);

				$id = $this->db->insert_id();

				$d['link_id'] = $id;
				echo json_encode($d);
				return;

			}else{
				echo json_encode('no title');
				return;

			}

		}else{

			echo json_encode('please login');
			return;
		}

	}

	//++++++++++++++++++++++++++++++++
	//CSV EXPORT AEP SUBSCRIBERS
	//++++++++++++++++++++++++++++++++

	public function export_aep_members_csv()
	{
			$this->load->model('aep_model');
			$this->admin_model->export_aep_members_csv();

	}

	
	
	//+++++++++++++++++++++++++++
	//AEP SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function aep_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('aep_model');
			$this->load->view('admin/aep_members/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD NEW AEP SUBSCRIBER
	//++++++++++++++++++++++++++

	public function add_aep_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('aep_model');
			$this->load->view('admin/aep_members/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	
	//+++++++++++++++++++++++++++
	//DELETE SUBSCRIBERS
	//++++++++++++++++++++++++++	
	function delete_aep_subscriber($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database1
			  $query = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('subscribers');
			  
			  //delete from database2
			  $query2 = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('aep_subscribers');			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/aep_subscribers/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//UPDATE AEP SUBSCRIBER
	//++++++++++++++++++++++++++

	public function update_aep_subscriber($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('aep_model');
			
			$member = $this->aep_model->get_member($mem_id, 'subscribers');
			
			$this->load->view('admin/aep/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}	
	
	
	
	
	
	
	//++++++++++++++++++++++++++++++++
	//CSV EXPORT MARATHON SUBSCRIBERS
	//++++++++++++++++++++++++++++++++

	public function export_members_csv()
	{
			$this->load->model('marathon_model');
			$this->marathon_model->export_members_csv();

	}

	
	
	//+++++++++++++++++++++++++++
	//MARATHON SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function marathon_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('marathon_model');
			$this->load->view('admin/marathon/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD NEW MARATHON SUBSCRIBER
	//++++++++++++++++++++++++++

	public function add_marathon_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('marathon_model');
			$this->load->view('admin/marathon/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	
	//+++++++++++++++++++++++++++
	//DELETE SUBSCRIBERS
	//++++++++++++++++++++++++++	
	function delete_marathon_subscriber($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database1
			  $query = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('subscribers');
			  
			  //delete from database2
			  $query2 = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('marathon_subscribers');			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/marathon_subscribers/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE MARATHON SUBSCRIBER
	//++++++++++++++++++++++++++

	public function update_marathon_subscriber($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('marathon_model');
			
			$member = $this->marathon_model->get_member($mem_id, 'subscribers');
			
			$this->load->view('admin/marathon/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	
			
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('members_model');
			$type['type'] = 'subscribers'; 
			$this->load->view('admin/members/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new SUBSCRIBER
	//++++++++++++++++++++++++++

	public function add_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$type['member_type'] = 'subscribers';
			$this->load->view('admin/members/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
		//DELETE IMAGE
	function delete_subscribers($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('subscribers');
			  
			  $test = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('subscriber_type_int');			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/subscribers/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER TYPES Do
	//++++++++++++++++++++++++++

	public function update_subscriber_types_do()
	{
		
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$this->members_model->update_subscriber_types_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}


	//+++++++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER PASSWORD Do
	//+++++++++++++++++++++++++++++++

	public function update_subscriber_pwd_do()
	{

		//$this->load->model('members_model');

		if($this->session->userdata('admin_id')){

			$this->load->model('members_model');
			$this->members_model->update_subscriber_pwd_do();

	 		//VALIDATE USER INPUT
	 		// $this->load->library('form_validation');

	 		// $this->form_validation->set_rules('txtpass', 'Password', 'trim|required|matches[txtpass_confirm]');
	 		// $this->form_validation->set_rules('txtpass_confirm', 'Confirmed Password', 'trim|required');

	 		// if ($this->form_validation->run() == FALSE)
	 		// {

	 		// 	echo validation_errors();

	 		// } else {

	 		// 	$pass = $this->input->post('txtpass', TRUE);
	 		// 	$password = md5($pass);

	 		// 	$this->members_model->update_subscriber_pwd_do($password);

	 		// }

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++++++++++++
	//LOGOUT SUBSCRIBER -- LOGIN_LOG TABLE
	//+++++++++++++++++++++++++++++++++++++

	public function logout_subscriber_do()
	{

		//$this->load->model('members_model');

		if($this->session->userdata('admin_id')){

			$this->load->model('members_model');
			$this->members_model->logout_subscriber_do();

	 		//VALIDATE USER INPUT
	 		// $this->load->library('form_validation');

	 		// $this->form_validation->set_rules('txtpass', 'Password', 'trim|required|matches[txtpass_confirm]');
	 		// $this->form_validation->set_rules('txtpass_confirm', 'Confirmed Password', 'trim|required');

	 		// if ($this->form_validation->run() == FALSE)
	 		// {

	 		// 	echo validation_errors();

	 		// } else {

	 		// 	$pass = $this->input->post('txtpass', TRUE);
	 		// 	$password = md5($pass);

	 		// 	$this->members_model->update_subscriber_pwd_do($password);

	 		// }

		}else{

			$this->load->view('admin/login');

		}

	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER
	//++++++++++++++++++++++++++

	public function update_subscribers($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'subscribers');
			$member['member_type'] = 'subscribers';
			//var_dump($member);
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}	
	
	

	//+++++++++++++++++++++++++++
	//SLIDERS
	//++++++++++++++++++++++++++

	public function sliders()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/sliders/sliders');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//update Slider sequence
	//++++++++++++++++++++++++++ 

	public function update_slider_sequence($slider_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('slider_id' , $slider_id);
			$this->db->update('sliders', $data);

		
	}
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS
	//++++++++++++++++++++++++++

	public function get_all_sliders()
	{
		$this->admin_model->get_all_sliders();
	}
	
	//+++++++++++++++++++++++++++
	//DELETE SLIDER
	//++++++++++++++++++++++++++

	public function delete_slider($id)
	{
		$this->db->where('slider_id', $id);
		$query = $this->db->get('sliders');
		

		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('slider_id', $id);
			$this->db->delete('sliders');
			$this->session->set_flashdata('msg','Slider removed successfully');		
			
		}
			
	}
	//GET SLIDER
	function get_slider($id, $x){

		$this->db->where('slider_id', $id);
		$query = $this->db->get('sliders');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				echo '<form id="slider-update" name="slider-update" method="post" action="'.site_url('/').'admin/update_slider_do" class="form-horizontal">
    						<input type="hidden" id="slider_id_edit" name="slider_id_edit" value="'.$row['slider_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Slider Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
							</div>
							 <div class="control-group">
								  <label class="control-label" for="slide_link">Slider Link</label>
								<div class="controls">
								   <input type="text" id="slide_link" name="slide_link" placeholder="Slider Link" value="'.$row['slug'].'">                    
								</div>
							 </div>
						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
                				<h5>Slider Text</h5>
                   				<textarea id="slider_edit" name="slider_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$("#slider_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Slider not found');	
			}
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE
	//++++++++++++++++++++++++++	
	function update_slider_do(){
			
			$status = strtolower($this->input->post('status_edit', TRUE));
			$title = $this->input->post('title_edit', TRUE);
			$url = $this->input->post('slide_link', TRUE);
			$id = $this->input->post('slider_id_edit', TRUE);
			$slider = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('slider_edit', FALSE)));

							
			$insertdata = array(
							  'title'=> $title ,
							  'slug'=> $url ,
							  'body'=> $slider ,
							  'status'=> $status
				);

			$this->db->where('slider_id', $id);
			$this->db->update('sliders',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully updated slider');	


	}

	//+++++++++++++++++++++++++++
	//FEEDBACK
	//++++++++++++++++++++++++++

	public function feedback()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/feedback/feedback');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}


	//+++++++++++++++++++++++++++
	//UPDATE FEEDBACK
	//++++++++++++++++++++++++++

	public function update_feedback($msg_id)
	{
		if($this->session->userdata('admin_id')){
			
			$msg = $this->admin_model->get_feedback_message($msg_id);
			$this->load->view('admin/feedback/update_feedback_message', $msg);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	

	 //+++++++++++++++++++++++++++
	//UPDATE FEEDBACK DO
	//++++++++++++++++++++++++++	
	function update_feedback_do()
	{

		$status = $this->input->post('status', TRUE);
		$msg_id = $this->input->post('msg_id', TRUE);
		$bus_id = $this->session->userdata('bus_id'); 
		$user = $this->session->userdata('u_name');   
			
		if($status == 'open'){
			
			$entry = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('update1', FALSE)));
			
			$table = 'feedback_updates';
			$new_status = 'review';
			$insertdata1 = array(
			  'bus_id'=> $bus_id,
			  'msg_id'=> $msg_id,
			  'user'=> $user,
			  'type'=> 'update1',
			  'update'=> $entry
			);			
				
		}
		
		if($status == 'review'){
			
			$entry = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('update2', FALSE)));
			$table = 'feedback_updates';
			$new_status = 'closure';
			
			$insertdata1 = array(
			  'bus_id'=> $bus_id,
			  'msg_id'=> $msg_id,
			  'user'=> $user,			
			  'type'=> 'update2',
			  'update'=> $entry,
			  'update_date'=> $entry_date,
			);				
				
		}				

		if($status == 'closure'){
			
			$entry = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('closure', FALSE)));
			$table = 'feedback_updates';	
			$new_status = 'closure';
			
			$insertdata1 = array(
			  'bus_id'=> $bus_id,
			  'msg_id'=> $msg_id,
			  'user'=> $user,			
			  'type'=> 'closure',	
			  'update'=> $entry ,
			  'update_date'=> $entry_date,
			);					
		}
		
				
		
		$insertdata2 = array(
		  'status'=> $new_status
		);					
			
			//VALIDATE INPUT
			if($entry == ''){
				$val = FALSE;
				$error = 'Please add content';
					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$this->db->insert($table, $insertdata1);
					
					$this->db->where('msg_id' , $msg_id);
					$this->db->update('feedback', $insertdata2);					
					
					
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_process_feedback-'. $id);
					$data['basicmsg'] = 'Feedback Process has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
							
								
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	
	
	 //+++++++++++++++++++++++++++
	//CLOSE FEEDBACK DO
	//++++++++++++++++++++++++++	
	function close_feedback_do()
	{

		$status = 'closed';
		$msg_id = $this->input->post('msg_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');   
							
		$insertdata2 = array(
		  'status'=> $status
		);					
			
				
		$this->db->where('msg_id' , $msg_id);
		$this->db->update('feedback', $insertdata2);					
		
		
		//success redirect	
		
		//LOG
		$this->admin_model->system_log('update_process_feedback-'. $id);
		$data['basicmsg'] = 'Feedback Ticket has been closed successfully';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				noty(options);</script>";
					
			
	}	
	
	

	//DELETE POST
	function delete_feedback($msg_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $query = $this->db->where('msg_id', $msg_id);
			  $query = $this->db->delete('feedback');
			  
			  $query2 = $this->db->where('msg_id', $msg_id);
			  $query2 = $this->db->delete('feedback_updates');	
			  
			  
			  $query4 = $this->db->where('msg_id', $msg_id);
			  $query4 = $this->db->delete('feedback_attach');				  	  		  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_feedback_message-'.$msg_id);
			  $this->session->set_flashdata('msg','Message deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/feedback/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	//+++++++++++++++++++++++++++
	//Businesses
	//++++++++++++++++++++++++++

	public function businesses()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/businesses/businesses');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}



	 //+++++++++++++++++++++++++++
	//UPDATE BUSINESS
	//++++++++++++++++++++++++++	
	function update_business_do()
	{
		$this->load->model('my_namibia_model');
		
		$business = $this->input->post('business');
		$bus_id = $this->session->userdata('bus_id');
		
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('na_businesses');		
		
		if(!empty($business)) {
			
			foreach($business as $bid) {		
			
				
			  $this->my_namibia_model->update_business_list($bid);	
			  
			}	
			
		}
		
			//LOG
			$this->admin_model->system_log('Business List Saved');
			$data['basicmsg'] = 'Business list has been saved';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);</script>";			
		
	}
	

	 //+++++++++++++++++++++++++++
	//UPDATE BUSINESS
	//++++++++++++++++++++++++++	
	function add_business_do($bid)
	{
	
		$bus_id = $this->session->userdata('bus_id');	
	
		$query = $this->db->where('business_id', $bid);  
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('na_businesses');	
		
		if(!$query->result()){		


			$this->load->model('my_namibia_model');	
			$this->my_namibia_model->add_business_do($bid);
			
				//LOG
				$this->admin_model->system_log('Business Added');
				$data['basicmsg'] = 'Business list has been saved';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";			
										
			
		
		} else {
			
			
				//LOG
				$this->admin_model->system_log('Business already added');
				$data['basicmsg'] = 'Business item already exists';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
						noty(options);</script>";				
			
		}
		
	}
	
	 //+++++++++++++++++++++++++++
	//UPDATE BUSINESS
	//++++++++++++++++++++++++++	
	function remove_business_do($bid, $page_id)
	{
	
		$bus_id = $this->session->userdata('bus_id');	
	
		$this->db->where('page_id', $page_id);
		$this->db->where('na_bus_id', $bid);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('na_businesses');	
			
			
		//LOG
		$this->admin_model->system_log('Business removed');
		$data['basicmsg'] = 'Business item removed';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
				noty(options);</script>";				
				
	}		


	//+++++++++++++++++++++++++++
	//Product Showcase
	//++++++++++++++++++++++++++

	public function property_show()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/showroom/showroom');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}	

	 //+++++++++++++++++++++++++++
	//UPDATE SHOWROOM
	//++++++++++++++++++++++++++	
	function update_show_do()
	{
		$this->load->model('my_namibia_model');
		
		$prop = $this->input->post('prop');
		$bus_id = $this->session->userdata('bus_id');
		
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('property_show');		
		
		if(!empty($prop)) {
			
			foreach($prop as $pid) {		
			
				
			  $this->my_namibia_model->update_prop_list($pid);	
			  
			}	
			
		}
		
			//LOG
			$this->admin_model->system_log('Property List Saved');
			$data['basicmsg'] = 'Property list has been saved';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);</script>";			
		
	}



	//+++++++++++++++++++++++++++
	//AGENT PROPERTIES
	//++++++++++++++++++++++++++

	public function agent_properties($id)
	{
		if($this->session->userdata('admin_id')){

			$data['id'] = $id;

			$this->load->model('my_namibia_model');
			$this->load->view('admin/agencies/properties', $data);

		}else{

			$this->load->view('admin/login');

		}
	}



	//+++++++++++++++++++++++++++
	//Agencies
	//++++++++++++++++++++++++++

	public function agencies()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/agencies/agencies');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}




	 //+++++++++++++++++++++++++++
	//UPDATE AGENCY
	//++++++++++++++++++++++++++	
	function update_agency_do()
	{
		$this->load->model('my_namibia_model');
		
		$agent = $this->input->post('agent');
		$bus_id = $this->session->userdata('bus_id');
		
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('property_agencies');		
		
		if(!empty($agent)) {
			
			foreach($agent as $aid) {		
			
				
			  $this->my_namibia_model->update_agent_list($aid);	
			  
			}	
			
		}
		
			//LOG
			$this->admin_model->system_log('Agency List Saved');
			$data['basicmsg'] = 'Agency list has been saved';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);</script>";			
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE AGENCY
	//++++++++++++++++++++++++++
	function update_property_feature_do()
	{
		$this->load->model('my_namibia_model');

		$agent = $this->input->post('agent');
		$property = $this->input->post('property');
		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('agent_id', $agent);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('agent_properties');

		if(!empty($property)) {

			foreach($property as $pid) {

				$this->my_namibia_model->update_agent_property_list($pid, $agent);

			}

		}


		//LOG
		$this->admin_model->system_log('Featured Properties List Saved');
		$data['basicmsg'] = 'Featured Properties list has been saved';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);</script>";

	}
	

	//+++++++++++++++++++++++++++
	//PUBLICATIONS
	//++++++++++++++++++++++++++

	public function publications()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/publications/publications');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//TESTIMONIALS
	//++++++++++++++++++++++++++

	public function testimonials()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/testimonials/testimonials');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//GET TESTIMONIAL FOR EDIT
	function get_testimonial($id){

		$this->db->where('testimonial_id', $id);
		$query = $this->db->get('testimonials');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				echo '<form id="testimonial-update" name="testimonial-update" method="post" action="'.site_url('/').'admin/update_testimonial_do" class="form-horizontal">
    						<input type="hidden" id="testimonial_id_edit" name="testimonial_id_edit" value="'.$row['testimonial_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Testimonial Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
</div>
							 <div class="control-group">
								  <label class="control-label" for="name_edit">Testimonial Reference</label>
								<div class="controls">
								   <input type="text" id="name_edit" name="name_edit" placeholder="Testimonial Reference" value="'.$row['heading'].'">                    
								</div>
							 </div>
						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
                				<h5>Testimonial</h5>
                   				<textarea id="testimonial_edit" name="testimonial_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$("#testimonial_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Testimonial not found');	
			}
	}
	//+++++++++++++++++++++++++++
	//TESTIMONIALS ADD 
	//++++++++++++++++++++++++++
	
		function add_testimonial_do(){
			
			$title = $this->input->post('title', TRUE);
			$language = $this->input->post('language', TRUE);
			$name = $this->input->post('name', TRUE);
			$testimonial = $this->input->post('testimonial', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
						
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages', 'add');
					
			}else{
				
				$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'pages', 'add');
				
			}
						
			$bus_id = $this->session->userdata('bus_id');

					
			$insertdata = array(
							  'title'=> $title ,
							  'heading'=> $name ,
							  'body'=> $testimonial ,
							  'bus_id'=> $bus_id,
							  'slug' => $slug,
							  'metaD' => $metaD,
							  'metaT' => $metaT,
							  'status' => 'draft',
							  'language' => $language
							  
				);
			$this->db->insert('testimonials',$insertdata);
			$testid = $this->db->insert_id();
				
			
			//LOG
			$this->admin_model->system_log('add_new_testimonial-'.$title);
			//success redirect	
			$this->session->set_flashdata('msg','Testimonial added successfully');
			$data['basicmsg'] = 'Testimonial has been added successfully';
			echo "
			<script type='text/javascript'>
			var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);
			window.location = '".site_url('/')."admin/update_testimonial/".$testid."/';
			</script>
			";
				
			
			
			
			
			
			
			
			
			

	}

	//+++++++++++++++++++++++++++
	//add new testimonial
	//++++++++++++++++++++++++++

	public function add_testimonial()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/testimonials/add_testimonial');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
	}

	
	//+++++++++++++++++++++++++++
	//Update Testimonials
	//++++++++++++++++++++++++++

	public function update_testimonial($testimonial_id)
	{
		if($this->session->userdata('admin_id')){
			
			$page = $this->admin_model->get_testimonial($testimonial_id);
			$page['settings'] = $this->get_config();
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/testimonials/update_testimonial', $page);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}	
	
	
	
	//+++++++++++++++++++++++++++
	//UPDATE
	//++++++++++++++++++++++++++	
	function update_testimonial_do(){
			
			$status = strtolower($this->input->post('status', TRUE));
			$title = $this->input->post('title', TRUE);
			$language = $this->input->post('language', TRUE);
			$name = $this->input->post('name', TRUE);
			$testimonial = $this->input->post('testimonial', TRUE);
			$id = $this->input->post('testimonial_id', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}		
				
			$insertdata = array(
							  'title'=> $title ,
							  'heading'=> $name ,
							  'body'=> $testimonial ,
							  'slug'=> $slug ,
							  'metaD'=> $metaD ,
							  'metaT'=> $metaT ,
							  'status'=> $status ,
							  'language'=> $language ,
							  'sequence'=> $sequence
				);

			$this->db->where('bus_id', $bus_id);
			$this->db->where('testimonial_id', $id);
			$this->db->update('testimonials',$insertdata);
			
					$data['testimonial_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_testimonial-'. $id);
					
					
					
					$data['basicmsg'] = 'Testimonial has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";


	}
	
	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL
	//++++++++++++++++++++++++++

	public function delete_testimonial($id)
	{
		$this->db->where('testimonial_id', $id);
		$this->db->delete('testimonials');
		//LOG
		$this->admin_model->system_log('delete-testimonial'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted testimonial');	
	}
		
	//+++++++++++++++++++++++++++
	//SIDEBARS
	//++++++++++++++++++++++++++

	public function sidebars()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/sidebars');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//update Sidebar sequence
	//++++++++++++++++++++++++++

	public function update_sidebar_sequence($sidebar_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('sidebar_id' , $sidebar_id);
			$this->db->update('sidebar_content', $data);

		
	}	
	
	//+++++++++++++++++++++++++++
	//SIDEBAR ADD 
	//++++++++++++++++++++++++++
	
		function add_sidebar_do(){
			
			$title = $this->input->post('sidebar_title', TRUE);
			$sidebar_type = $this->input->post('sidebar_type', TRUE);
			$sidebar = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('sidebar_content', FALSE))); 
			$gal_id = $this->input->post('sidebar_gal', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			
			if($gal_id != "") { $gal_id = $this->input->post('sidebar_gal', TRUE); } 
					
			$insertdata = array(
							  'title'=> $title ,
							  'body'=> $sidebar ,
							  'sidebar_type'=> $sidebar_type,
							  'gal_id'=> $gal_id,
							  'bus_id'=> $bus_id
							  
				);
			$this->db->insert('sidebar_content',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully added sidebar');	

	}
	
	

	//GET SIDEBAR FOR EDIT
	function get_sidebar($id){

		$this->db->where('sidebar_id', $id);
		$query = $this->db->get('sidebar_content');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				$gallery_selected = "";
				$contact_selected = "";
				$downloads_selected = "";
				$feature_selected = "";
				
				if($row['sidebar_type'] == 'gallery' ) { $gallery_selected = 'selected'; }
				if($row['sidebar_type'] == 'contact' ) { $contact_selected = 'selected'; }
				if($row['sidebar_type'] == 'downloads' ) { $downloads_selected = 'selected'; }
				if($row['sidebar_type'] == 'feature_image' ) { $feature_selected = 'selected'; }
				
				echo '<form id="sidebar-update" name="sidebar-update" method="post" action="'.site_url('/').'admin/update_sidebar_do" class="form-horizontal">
    						<input type="hidden" id="sidebar_id_edit" name="sidebar_id_edit" value="'.$row['sidebar_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Sidebar Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
							 </div>

						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							
							  <div class="control-group">
									<h5>Sidebar Type</h5>
									<select name="sidebar_u_type" id="sidebar_u_type">
										<option value="">None</option>
										<option value="gallery" '.$gallery_selected.'>Gallery</option>
										<option value="downloads" '.$downloads_selected.'>Downloads</option>
										<option value="contact" '.$contact_selected.'>Contact</option>
										<option value="feature_image" '.$feature_selected.'>Feature Image</option>
									</select>
							  </div>';
							  							
							if($row['sidebar_type'] != 'gallery' ) { $hide = 'style="display:none;"'; } else { $hide = ''; }
								
						echo  '<div class="control-group" id="sidebar_u_div" '.$hide.' >'; 
								
								echo $this->admin_model->get_option_gallery($row['gal_id']);
								
						echo  '</div>';
								
							
							
					echo'	<div class="control-group">
                				<h5>Sidebar</h5>
                   				<textarea id="sidebar_edit" name="sidebar_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$(document).ready(function() {
										$("#sidebar_u_type").on("change", function(){
													console.log("hi");
													if($(this).val() == "gallery"){
														
														$("#sidebar_u_div").slideDown();
														
													}else{
														
														$("#sidebar_u_div").slideUp();
														
													}
													
										});								
									});
									
									$("#sidebar_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table", "link","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Sidebar not found');	
			}
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE SIDEBAR
	//++++++++++++++++++++++++++	
	function update_sidebar_do(){
			
		$status = strtolower($this->input->post('status_edit', TRUE));
		$title = $this->input->post('title_edit', TRUE);
		$sidebar_type = $this->input->post('sidebar_u_type', TRUE);
		$gal_id = $this->input->post('sidebar_gal', TRUE);
		
		$sidebar = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('sidebar_edit', FALSE))); 
		$id = $this->input->post('sidebar_id_edit', TRUE);
		
		if($gal_id != "") { $gal_id = $this->input->post('sidebar_gal', TRUE); } 
			
		$insertdata = array(
		  'title'=> $title,
		  'body'=> $sidebar,
		  'sidebar_type'=> $sidebar_type,
		  'gal_id' => $gal_id,
		  'status'=> $status
		);

		$this->db->where('sidebar_id', $id);
		$this->db->update('sidebar_content',$insertdata);
		$this->session->set_flashdata('msg', 'Successfully updated sidebar');	

	}
	
	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL
	//++++++++++++++++++++++++++

	public function delete_sidebar($id)
	{
		$this->db->where('sidebar_id', $id);
		$this->db->delete('sidebar_content');
		//LOG
		$this->admin_model->system_log('delete-sidebar'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted sidebar');	
	}
		
	//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function members()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('members_model');
			$type['type'] = 'members'; 
			$this->load->view('admin/members/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE IMAGE
	function delete_members($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('member_id', $mem_id);
			  $this->db->delete('members');
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/members/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++

	public function update_members($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'members');
			$member['member_type'] = 'members';
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new MEMEBR
	//++++++++++++++++++++++++++

	public function add_members()
	{
		if($this->session->userdata('admin_id')){
			$type['member_type'] = 'members';
			$this->load->view('admin/members/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD MEMBER
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
		$this->load->model('members_model');
		$this->members_model->add_member_do();
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
		$this->load->model('members_model');
		$this->members_model-> update_member_do();
	}

	//+++++++++++++++++++++++++++
	//UPDATE MEMBER STATUS
	//++++++++++++++++++++++++++	
	//function update_member_status($status, $member_id, $type_id="")
	function update_member_status()
	{

		$status = $this->input->post('status');
		$member_id = $this->input->post('member_id');
		$type_id = $this->input->post('type_id');

		$this->load->model('members_model');
		$this->members_model->update_member_status($status, $member_id, $type_id);
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE MARATHON MEMBER
	//++++++++++++++++++++++++++	
	function update_marathon_member_do()
	{
		$this->load->model('marathon_model');
		$this->marathon_model->update_member_do();
	}	

	//+++++++++++++++++++++++++++
	//UPDATE AEP MEMBER
	//++++++++++++++++++++++++++	
	function update_aep_member_do()
	{
		$this->load->model('aep_model');
		$this->aep_model->update_member_do();
	}	
	
	//+++++++++++++++++++++++++++
	//DOCUMENTS
	//++++++++++++++++++++++++++

	public function documents()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/documents/documents');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}

	
	
	
	//+++++++++++++++++++++++++++
	//IMAGES/GALLERIES
	//++++++++++++++++++++++++++

	public function images()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/images');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//DELETE IMAGE
	function delete_image($img_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('img_id', $img_id);
			  $this->db->delete('images');
			  //LOG
			  $this->admin_model->system_log('delete_image-'.$img_id);
			  $this->session->set_flashdata('msg','Image deleted successfully');
			  echo '<script type="text/javascript">
				  
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_gallery_image($img_id)
	{
		$this->db->where('img_id', $img_id);
		
		$query = $this->db->get('images');

		if($query->result()){
			$row = $query->row_array();
			
			echo '<div class="row-fluid">
					<form id="image-update" name="image-update" method="post" action="'. site_url('/').'admin/update_image_do" >
                       <fieldset>
                        <input type="hidden" id="update_img_id" name="update_img_id" value="'.$img_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="img_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_title" name="img_title" placeholder="Image title" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="img_name">Body</label>
                              <div class="controls">
                                      
									  <textarea  name="img_body" class="redactor" style="display:block">'.$row['body'].'</textarea>
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="img_title">URL</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_url" name="img_url" placeholder="URL" value="'.$row['url'].'">
                              </div>
                        </div>						
						<input type="submit" id="update_img_but" value="Update Image" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					
					
					  $(".redactor").redactor({ 	
								  buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
								  "unorderedlist", "orderedlist", "outdent", "indent", "|","image",
								  "video", "table","|",
								   "alignment", "|", "horizontalrule"]
					  });
					
					$("#update_img_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#image-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'admin/update_image_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_images();
							  $("#modal-img-update").modal("hide");
							  
							}
						  });
		
					});
				
				</script>
				
				';	
			
		}
			
	}


	//+++++++++++++++++++++++++++
	//DELETE GALLERY CATEGORY
	//++++++++++++++++++++++++++

	public function delete_gallery_category($id)
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->delete_gallery_category($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//RELOAD GALLERY CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_gallery_category_all()
	{
		$this->admin_model->get_all_gallery_categories();

	}


	//+++++++++++++++++++++++++++
	//update Image
	//++++++++++++++++++++++++++

	public function update_image_do()
	{
		$this->admin_model->update_image_do();
			
	}
	
	public function galleries()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/galleries');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}


	public function gallery_categories()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/images/categories');

		}else{

			$this->load->view('admin/login');

		}
	}


	//+++++++++++++++++++++++++++
	//ADD CATEGORY
	//++++++++++++++++++++++++++

	public function add_gallery_category()
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->add_gallery_category();

		}else{

			$this->load->view('admin/login');

		}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++
	//ADD GALLERY CATEGORY AND INTERSECTION FOR POST
	//++++++++++++++++++++++++++++++++++++++++++++++

	public function add_category_gallery()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$gallery_id = $this->input->post('gallery_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('gallery_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('gallery_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('gallery_categories');

		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('gallery_id', $gallery_id);
		$result = $this->db->get('gallery_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['gallery_id'] = $gallery_id;
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('gallery_cat_int', $data2);
		}

	}


	//+++++++++++++++++++++++++++
	//DELETE CATEGORY GALLERY
	//++++++++++++++++++++++++++

	public function delete_category_gallery($id)
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->delete_category_gallery($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY MEMBERS
	//++++++++++++++++++++++++++

	public function reload_category_gallery($gallery_id)
	{
		$this->admin_model->get_gallery_categories_current($gallery_id);

	}


	//+++++++++++++++++++++++++++
	//add new gallery
	//++++++++++++++++++++++++++

	public function add_gallery()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/add_gallery');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD GALLERY DO
	//++++++++++++++++++++++++++	
	function add_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$style = $this->input->post('style', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title, $replace=array(), $delimiter='-' , 'gallery', 'add');

			}else{
				
				$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'gallery', 'add');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Gallery title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
//							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'description'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT, 
								  'style'=> $style, 
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('galleries', $insertdata);
					//LOG
					$this->admin_model->system_log('add_new_gallery-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Gallery added successfully');
					$data['basicmsg'] = 'Gallery has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/galleries/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function update_gallery($gal_id)
	{
		if($this->session->userdata('admin_id')){
			
			$gallery = $this->admin_model->get_gallery($gal_id);
			$this->load->view('admin/images/update_gallery', $gallery);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE GALLERY
	//++++++++++++++++++++++++++	
	function update_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);

			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('gallery_id', TRUE);
			$style = $this->input->post('style', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Gallery title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'description'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT, 
								  'style'=> $style, 
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('gal_id' , $id);
					$this->db->update('galleries', $insertdata);
					//success redirect	
					$data['gallery_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_gallery-'. $id);
					$data['basicmsg'] = 'Gallery has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
		
	//+++++++++++++++++++++++++++
	//delete gallery
	//++++++++++++++++++++++++++

	public function delete_gallery($gal_id)
	{
		
		$this->db->where('gal_id', $gal_id);
		$query = $this->db->get('images');
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('gal_id', $gal_id);
			$this->db->delete('images');

			$this->db->where('gallery_id', $gal_id);
			$this->db->delete('gallery_cat_int');
		}
		
		$this->db->where('gal_id', $gal_id);
		$this->db->delete('galleries');
		$this->session->set_flashdata('msg','Gallery removed successfully');
		echo '<script type="text/javascript">
				window.location = "'.site_url('/').'admin/galleries/"
				
			</script>';	
			
	}
	//+++++++++++++++++++++++++++
	//UPDATE SIDEBAR
	//++++++++++++++++++++++++++

	public function update_sidebar($ctype, $cid, $stype, $sid )
	{
		if($this->session->userdata('admin_id')) {

			if ($sid != 0){

				$bus_id = $this->session->userdata('bus_id');
			//DELETE OLD RECORDS
			/*$this->db->where($ctype . '_id', $cid);
			$this->db->where('type', $stype);
			$this->db->where('bus_id', $bus_id);
			$this->db->delete('sidebars');*/

			//insert new 
			$data[$ctype . '_id'] = $cid;
			$data['type'] = $stype;
			$data['bus_id'] = $bus_id;
			$data['type_id'] = $sid;
			$this->db->insert('sidebars', $data);

		}
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//REMOVE GALLERY SIDEBAR
	//++++++++++++++++++++++++++

	public function remove_sidebar($ctype, $cid, $stype, $sid)
	{
		if($this->session->userdata('admin_id')){
			
			//DELETE OLD RECORDS
			$this->db->where($ctype.'_id', $cid);
			$this->db->where('type', $stype);
			$this->db->where('type_id', $sid);
			$this->db->delete('sidebars');
			
			$this->admin_model->get_sidebar_content($ctype.'_'.$cid);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	
	//+++++++++++++++++++++++++++
	//PROJECTS
	//++++++++++++++++++++++++++

	public function projects()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/projects/projects');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function add_project()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/projects/add_project');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function update_project($project_id)
	{
		if($this->session->userdata('admin_id')){
			
			$project = $this->admin_model->get_project($project_id);
			$this->load->view('admin/projects/update_project', $project);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//load_documents for Project
	//++++++++++++++++++++++++++

	public function load_documents($project_id)
	{
		
		$this->admin_model->get_project_docs($project_id);
		
				
	}
	//+++++++++++++++++++++++++++
	//load_documents
	//++++++++++++++++++++++++++

	public function get_all_documents()
	{
		
		$this->admin_model->get_all_documents();
		
				
	}
	//+++++++++++++++++++++++++++
	//delete document
	//++++++++++++++++++++++++++

	public function delete_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);
		
		if($type == 'project_docs'){
			
			$query = $this->db->get('project_documents');
			$del = 'project_documents';
		}else{
			
			$query = $this->db->get('documents');
			$del = 'documents';
		}
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/documents/' . $row['doc_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('doc_id', $doc_id);
			$this->db->delete($del);
			$this->session->set_flashdata('msg','Document removed successfully');		
			
		}
			
	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);
		
		if($type == 'project_docs'){
			
			$query = $this->db->get('project_documents');
		}else{
			
			$query = $this->db->get('documents');
			
		}
		
		if($query->result()){
			$row = $query->row_array();
			
			if($row['download'] == 'no'){
					
					$live = '';
					$draft = 'active';	
					
			}else{
					
					$live = 'active';
					$draft = '';	
			}
			
			echo '<div class="row-fluid">
					<form id="document-update" name="document-update" method="post" action="'. site_url('/').'admin/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="update_doc_id" value="'.$doc_id.'" />
						<input type="hidden" id="doc_type" name="doc_type" value="'.$type.'" />
                        <div class="control-group">
                              <label class="control-label" for="doc_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_title" name="doc_title" placeholder="Document title eg: Appendix A" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="doc_name">Name</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_name" name="doc_name" placeholder="Document name" value="'.$row['description'].'">
                              </div>
                        </div>
						   <div class="control-group">
							  <label class="control-label" for="download">Available in Downloads</label>
							  <div class="controls">
									  <div class="btn-group download" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">No</button>
										<button type="button" class="btn btn-primary '.$live.'">Yes</button>
									  </div>
							  </div>
							  <input type="hidden" name="download" id="download"  value="'. $row['download'].'">
							</div>
						<input type="submit" id="update_doc_but" value="Update Document" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					$("#update_doc_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#document-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'admin/update_document_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_documents();
							  $("#modal-doc-update").modal("hide");
							  
							}
						  });
		
					});
					
								
			
				$("div.download button").live("click", function(){
					
					$("#download").attr("value", $(this).html());
				}); 
				</script>
				
				';	
			
		}
			
	}
	//+++++++++++++++++++++++++++
	//update Doc sequence
	//++++++++++++++++++++++++++

	public function update_doc_sequence($doc_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('doc_id' , $doc_id);
			$this->db->update('project_documents', $data);

		
	}
	
	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$this->admin_model->update_document_do();
			
	}				       
	//+++++++++++++++++++++++++++
	//ADD PROJECT DO
	//++++++++++++++++++++++++++	
	function add_project_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$type = $this->input->post('type', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		
			if($slug == ''){
				$slug = $this->clean_url_str($title, $replace=array(), $delimiter='-' , 'project', 'add');
			}else{
				$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'project', 'add');
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Project title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
//							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug,
								  'type'=> $type,
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('projects', $insertdata);
					//LOG
					$this->admin_model->system_log('add_new_project-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Project added successfully');
					$data['basicmsg'] = 'Project has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/projects/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
		
	 //+++++++++++++++++++++++++++
	//UPDATE PROJECT
	//++++++++++++++++++++++++++	
	function update_project_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$type = $this->input->post('type', TRUE);
			$status = $this->input->post('status', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('project_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Project title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'status'=> strtolower($status),
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug,
								  'type'=> $type,
								  'bus_id'=>$bus_id 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('project_id' , $id);
					$this->db->update('projects', $insertdata);
					//success redirect	
					$data['project_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_project-'. $id);
					$data['basicmsg'] = 'Project has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//DELETE PROJECT
	function delete_project($project_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('project_id', $project_id);
			  $this->db->delete('projects');
			  //LOG
			  $this->admin_model->system_log('delete_project-'.$project_id);
			  $this->session->set_flashdata('msg','Project deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/projects/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//upload project docs 
	//++++++++++++++++++++++++++
	
	function plupload_server($document)
	{
		//Document is for distinguisj=hing between projects and normal documents
		$this->admin_model->plupload_server($document);
		
	}
	
	//+++++++++++++++++++++++++++
	//MULTI ADD CATEGORY
	//++++++++++++++++++++++++++

	public function category_multi_add()
	{
		$this->admin_model->category_multi_add();
	}
		
	
	 //+++++++++++++++++++++++++++
	//upload project docs 
	//++++++++++++++++++++++++++
	
	function add_project_docs()
	{
		$document = 'project_docs';
		$this->admin_model->add_project_docs($document);
		
	}
	
	//+++++++++++++++++++++++++++
	//upload DOCUMENTS
	//++++++++++++++++++++++++++
	
	function add_documents()
	{
		$document = 'documents';
		$this->admin_model->add_project_docs($document);
		
	}
	
	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		$this->admin_model->add_gallery_images();
		
	}
	//+++++++++++++++++++++++++++
	//update Gall Image sequence
	//++++++++++++++++++++++++++

	public function update_img_sequence($img_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('img_id' , $img_id);
			$this->db->update('images', $data);

		
	}
	//+++++++++++++++++++++++++++
	//load gallery images For sidebars
	//++++++++++++++++++++++++++
	
	function load_gallery_images($gal_id)
	{
		
		$this->admin_model->get_gallery_titles($gal_id);
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($gal_id)
	{
		
		$this->admin_model->load_gallery_images_update($gal_id);
		
	}
	
	
// 	//+++++++++++++++++++++++++++
// 	//ADVERTS
// 	//++++++++++++++++++++++++++

// 	public function adverts()
// 	{
// 		if($this->session->userdata('admin_id')){
			
// 			$this->load->view('admin/adverts/adverts');
			
// 		}else{
			
// 			$this->load->view('admin/login');
			
// 		}	
// 	}
	
// 	//+++++++++++++++++++++++++++
// 	//add new advert
// 	//++++++++++++++++++++++++++

// 	public function add_advert()
// 	{
// 		if($this->session->userdata('admin_id')){
			
// 			$this->load->view('admin/adverts/add_advert');
			
// 		}else{
			
// 			$this->load->view('admin/login');
			
// 		}
		
		
// 	}
// 	//+++++++++++++++++++++++++++
// 	//update advert
// 	//++++++++++++++++++++++++++

// 	public function update_advert($advert_id)
// 	{
// 		if($this->session->userdata('admin_id')){
			
// 			$advert = $this->admin_model->get_advert($advert_id);
// 			$advert['settings'] = $this->get_config();
			
// 			$this->load->model('my_namibia_model');
// 			$this->load->view('admin/adverts/update_advert', $advert);
			
// 		}else{
			
// 			$this->load->view('admin/login');
			
// 		}
		
		
// 	}
// 	//+++++++++++++++++++++++++++
// 	//ADD ADVERT DO
// 	//++++++++++++++++++++++++++	
// 	function add_advert_do()
// 	{
// 			$title = $this->input->post('title', TRUE);
// 			$slug = $this->input->post('slug', TRUE);
// 			$url = $this->input->post('url', TRUE);
// 			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
// 			$metaT = $this->input->post('metaT', TRUE);
// 			$metaD = $this->input->post('metaD', TRUE);
// 			$bus_id = $this->session->userdata('bus_id');
		  
// 			if($slug == ''){
				
// 				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages');
					
// 			}else{
				
// 				$slug = $this->clean_url_str($slug);
				
// 			}
			
// 			//VALIDATE INPUT
// 			if($title == ''){
// 				$val = FALSE;
// 				$error = 'Advert Title Required';
// 			}elseif(!$this->session->userdata('admin_id')){
				
// 				$val = FALSE;
// 				$error = 'You are logged out. Please sign in again.';
// 			//}elseif($this->validate_cell($cellNum)){
// //				$val = FALSE;
// //				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
// //			}elseif($body == ''){
// //				$val = FALSE;
// //				$error = 'Page Content Required';	
							
// 			}else{
// 				$val = TRUE;
// 			}
			
// 				$insertdata = array(
// 				  'title'=> $title,
// 				  'url'=> $url,
// 				  'body'=> $body,
// 				  'metaD'=> $metaD,
// 				  'metaT'=> $metaT,
// 				  'slug'=> $slug,
// 				  'bus_id'=>$bus_id
// 				);
			
	
			
// 			if($val == TRUE){
				
					
// 					$this->db->insert('adverts', $insertdata);
// 					$advertid = $this->db->insert_id();
// 					//LOG
// 					$this->admin_model->system_log('add_new_advert-'.$title);
// 					//success redirect	
// 					$this->session->set_flashdata('msg','Advert added successfully');
// 					$data['basicmsg'] = 'Advert has been added successfully';
// 					echo "
// 					<script type='text/javascript'>
// 					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
// 				            noty(options);
// 					window.location = '".site_url('/')."admin/update_advert/".$advertid."/';
// 					</script>
// 					";
// 			}else{
// 					$data['id'] = $this->session->userdata('id');
// 					$data['error'] = $error;
// 					echo "
// 					<script type='text/javascript'>
// 					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
// 				            noty(options);
					
// 					</script>
// 					";
// 					$this->output->set_header("HTTP/1.0 200 OK");
				
// 			}
// 	}	
// 	 //+++++++++++++++++++++++++++
// 	//UPDATE PAGE
// 	//++++++++++++++++++++++++++	
// 	function update_advert_do()
// 	{
// 			$title = $this->input->post('title', TRUE);
// 			$slug = $this->input->post('slug', TRUE);		
// 			$status = $this->input->post('status', TRUE);
// 			$url = $this->input->post('url', TRUE);
			
// 			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

// 			$metaT = $this->input->post('metaT', TRUE);
// 			$metaD = $this->input->post('metaD', TRUE);
// 			$id = $this->input->post('advert_id', TRUE);
// 		 	$bus_id = $this->session->userdata('bus_id');
// 			$sequence = $this->input->post('sequence', TRUE);
			
// 			if($slug == ''){
				
// 				$slug = $this->clean_url_str($title);
					
// 			}else{
				
// 				$slug = $this->clean_url_str($slug);
				
// 			}
			
// 			//VALIDATE INPUT
// 			if($title == ''){
// 				$val = FALSE;
// 				$error = 'Advert Title Required';
			
// 			}elseif(!$this->session->userdata('admin_id')){
				
// 				$val = FALSE;
// 				$error = 'You are logged out. Please sign in again.';		
// 			//}elseif($this->validate_cell($cellNum)){
// //				$val = FALSE;
// //				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
// 			/*}elseif(strip_tags($body) == ''){
// 				$val = FALSE;
// 				$error = 'Page Content Required';*/	
							
// 			}else{
// 				$val = TRUE;
// 			}
			
// 				$insertdata = array(
// 				  'title'=> $title ,
// 				  'status'=> strtolower($status),
// 				  'url'=> $url,
// 				  'body'=> $body,
// 				  'metaD'=> $metaD,
// 				  'metaT'=> $metaT,
// 				  'slug'=> $slug ,								  
// 				  'bus_id'=>$bus_id,
// 				  'sequence'=> $sequence
// 				);
			
	
			
// 			if($val == TRUE){
				
// 					$this->db->where('advert_id' , $id);
// 					$this->db->update('adverts', $insertdata);
// 					//success redirect	
// 					$data['advert_id'] = $id;
					
// 					//LOG
// 					$this->admin_model->system_log('update_advert-'. $id);
					
					
					
// 					$data['basicmsg'] = 'Advert has been updated successfully';
// 					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
// 				            noty(options);</script>";
					
// 			}else{
					
// 					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
// 				            noty(options);</script>";
				
// 			}
// 	}
	
	
// 	//DELETE ADVERT
// 	function delete_advert($advert_id){
      	
// 		if($this->session->userdata('admin_id')){
			
		
// 			  //delete from database
// 			  $query = $this->db->where('advert_id', $advert_id);
// 			  $query =  $this->db->delete('adverts');
			 
// 			  //LOG
// 			  $this->admin_model->system_log('delete_advert-'.$advert_id);
// 			  $this->session->set_flashdata('msg','Advert deleted successfully');
// 			  echo '<script type="text/javascript">
// 				   window.location = "'.site_url('/').'admin/adverts/";
// 				  </script>';
						
			
// 		}else{
			
// 			redirect(site_url('/').'admin/logout/','refresh');
				
// 		}
//     }
	
	
	//+++++++++++++++++++++++++++
	//CHARTS
	//++++++++++++++++++++++++++

	public function charts()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('chart_model');
			$this->load->view('admin/charts/charts');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//ADD NEW CHART
	//++++++++++++++++++++++++++

	public function add_chart()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('chart_model');
			$this->load->view('admin/charts/add_chart');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE CHART
	//++++++++++++++++++++++++++

	public function update_chart($chart_id)
	{
			
		if($this->session->userdata('admin_id')){
		
			$this->load->model('chart_model');
				
			$chart = $this->chart_model->get_chart($chart_id);
			$chart['settings'] = $this->get_config();
			
			$this->load->view('admin/charts/update_chart', $chart);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//ADD CHART DO
	//++++++++++++++++++++++++++	
	function add_chart_do()
	{
		
			$title = $this->input->post('title', TRUE);
			$x_title = $this->input->post('x_title', TRUE);
			$y_title = $this->input->post('y_title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$type = $this->input->post('type', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$category = $this->input->post('category', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
		  	echo $x_title;
		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'charts');
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Chart title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'bus_id'=>$bus_id,
					  'cat_id'=> $category,
					  'title'=> $title ,
					  'heading'=> $heading ,
					  'slug'=> $slug ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'description'=> $body ,
					  'x_title'=> $x_title,
					  'y_title'=> $y_title,								  
					  'type'=> $type,	
					  'sequence'=> $sequence
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('charts', $insertdata);
					$chartid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_chart-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Chart added successfully');
					$data['basicmsg'] = 'Chart has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."admin/update_chart/".$chartid."/';
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
		
    //+++++++++++++++++++++++++++
	//UPDATE CHART
	//++++++++++++++++++++++++++	
	function update_chart_do()
	{
			$id = $this->input->post('id', TRUE);
			$active = $this->input->post('active', TRUE);
			$title = $this->input->post('title', TRUE);
			$x_title = $this->input->post('x_title', TRUE);
			$y_title = $this->input->post('y_title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$type = $this->input->post('type', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$category = $this->input->post('category', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			
			
			if($active=='Draft') { $active = 'N'; }
			if($active=='Live') { $active = 'Y'; }
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Chart Title Required';
				
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}


				$insertdata = array(
					  'bus_id'=>$bus_id,
					  'active'=> $active,
					  'cat_id'=> $category,
					  'title'=> $title,
					  'heading'=> $heading,
					  'slug'=> $slug,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'description'=> $body,
					  'x_title'=> $x_title,
					  'y_title'=> $y_title,								  
					  'type'=> $type,	
					  'sequence'=> $sequence
					);
			
			
			
			if($val == TRUE){
	
					$this->db->where('chart_id' , $id);
					$this->db->update('charts', $insertdata);
					//success redirect	
					$data['chart_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_achart-'. $id);
					
					
					
					$data['basicmsg'] = 'Chart has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	
	//DELETE CHART
	function delete_chart($chart_id){
      	
		if($this->session->userdata('admin_id')){
					
			  //delete from database
			  $query = $this->db->where('chart_id', $chart_id);
			  $query =  $this->db->delete('charts');
			  

			  $query = $this->db->where('chart_id', $chart_id);
			  $query =  $this->db->delete('chart_datasets');			  
			 
			  //LOG
			  $this->admin_model->system_log('delete_chart-'.$chart_id);
			  $this->session->set_flashdata('msg','Chart deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/charts/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	//+++++++++++++++++++++++++++
	//ADD DATASET DO
	//++++++++++++++++++++++++++	
	function add_dataset_do()
	{
		

		$set_title = $this->input->post('set_title', TRUE);
		//$set_color = $this->input->post('set_color', TRUE);
		$chart_id = $this->input->post('chart_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$labels = "";
		$values = "";
		
		$query = $this->db->where('chart_id', $chart_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_datasets');
		
		if($query->result()){		
		
			$row = $query->row();
			$labels = $row->labels;
			$values = array();
			$count = json_decode($row->labels);
			
			foreach($count as $ct) {
				array_push($values, "");
			}
			
			$values = json_encode($values);
		
		}
		  
			
			//VALIDATE INPUT
			if($set_title == ''){
				$val = FALSE;
				$error = 'Dataset title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
				
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'bus_id'=>$bus_id,
					  'chart_id'=> $chart_id,
					  'set_title'=> $set_title,
					  'labels'=> $labels,
					  'data_values'=> $values
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('chart_datasets', $insertdata);
					$dataid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_chart-'.$title);
					//success redirect	


					$data['basicmsg'] = 'Dataset: '.$title.' has been added successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
							noty(options);</script>";		

			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	public function reload_datasets($chart_id)
	{
		$this->load->model('chart_model');
		$this->chart_model->get_datasets($chart_id);
		
	}		
	
	//+++++++++++++++++++++++++++
	//ADD DATAROW DO
	//++++++++++++++++++++++++++	
	function add_datarow_do($did, $cid)
	{	
	
		
		$bus_id = $this->session->userdata('bus_id');
			
		$query = $this->db->select('labels, data_values');
		$query = $this->db->where('chart_id', $cid);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_datasets');
		
		if($query->result()){
			
			foreach($query->result() as $row){	
			
				//$row = $query->row();		
				
				if($row->labels == '') {
					
					echo 'hi';
					
					$labels = array("");
					$values = array("");
					
				} else {
					
					$labels = json_decode($row->labels);
					$values = json_decode($row->data_values);
					
					array_push($labels, "");
					array_push($values, "");
	
					
				}
				
				$labels = json_encode($labels);
				$values = json_encode($values);
	
				$insertdata = array(
					'labels'=>$labels,
					'data_values'=>$values
				);
				
				$this->db->where('chart_id' , $cid);
				$this->db->update('chart_datasets', $insertdata);
				
					$data['basicmsg'] = 'Datarow has been added successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
							noty(options);</script>";				
				
			}
			
		}
	
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD DATAROW DO
	//++++++++++++++++++++++++++	
	function update_dataset_do()
	{	
		$title = $this->input->post('upd_title');
		$color = $this->input->post('upd_color');
		$set_labels = $this->input->post('set_label');
		$set_values = $this->input->post('set_value');	
		$did = $this->input->post('did');	
		$cid = $this->input->post('cid');	
		$bus_id = $this->session->userdata('bus_id');

		
		echo $did;
		
		$labels = array();
		$values = array();
		
		foreach($set_labels as $lid) {
	
			array_push($labels, $lid);	
			
		}
		
		
		foreach($set_values as $vid) {
			
			array_push($values, $vid);	
			
		}

		$labels = json_encode($labels);
		$values = json_encode($values);
		
		
		$insertdata = array(
			'set_title'=>$title,
			'data_color'=>$color,
			'labels'=>$labels,
			'data_values'=>$values
		);
		
		$insertdata2 = array(
			'labels'=>$labels
		);		
		
		$this->db->where('dataset_id' , $did);
		$this->db->update('chart_datasets', $insertdata);
		
		$this->db->where('chart_id' , $cid);
		$this->db->update('chart_datasets', $insertdata2);
		
		$data['basicmsg'] = 'Dataset: '.$title.' has been updated successfully';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				noty(options);</script>";									
	
	}	
	
	 //+++++++++++++++++++++++++++
	//REMOVE DATASET
	//++++++++++++++++++++++++++	
	function remove_dataset($id)
	{
	
		$bus_id = $this->session->userdata('bus_id');	
	
		$this->db->where('dataset_id', $id);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('chart_datasets');	
			
			
		//LOG
		$this->admin_model->system_log('Dataset removed');
		$data['basicmsg'] = 'Dataset item removed';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
				noty(options);</script>";				
				
	}
	
	//+++++++++++++++++++++++++++
	//REMOVE DATAROW
	//++++++++++++++++++++++++++	
	function remove_datarow($i, $cid, $did)
	{
	
		$bus_id = $this->session->userdata('bus_id');	
	
		$query = $this->db->select('labels, data_values');
		$query = $this->db->where('dataset_id', $did);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_datasets');
		
		if($query->result()){
		
		$row = $query->row();
		
		$labels = json_decode($row->labels);
		$values = json_decode($row->data_values);
		
		unset($labels[$i]);
		unset($values[$i]);
		
		$labels2 = array_values($labels);
		$values2 = array_values($values);
		
		$labels = json_encode($labels2);
		$values = json_encode($values2);				
		
		$insertdata2 = array(
			'labels'=>$labels,
			'data_values'=>$values
		);		
		

		$this->db->where('chart_id' , $cid);
		$this->db->update('chart_datasets', $insertdata2);		
				
		//LOG
		$this->admin_model->system_log('Dataset removed');
		$data['basicmsg'] = 'Dataset item removed';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
				noty(options);</script>";	
				
				
		}
				
	}		
		

	//+++++++++++++++++++++++++++
	//update Chart sequence
	//++++++++++++++++++++++++++

	public function update_chart_sequence($chart_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('chart_id' , $chart_id);
		$this->db->update('charts', $data);	
	}
	
	//+++++++++++++++++++++++++++
	//update Chart Cat sequence
	//++++++++++++++++++++++++++

	public function update_chart_cat_sequence($cat_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('cat_id' , $cat_id);
		$this->db->update('chart_categories', $data);	
	}	
	
	//+++++++++++++++++++++++++++
	//update Recipe Cat sequence
	//++++++++++++++++++++++++++

	public function update_recipe_cat_sequence($cat_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('cat_id' , $cat_id);
		$this->db->update('recipe_categories', $data);	
	}					
	
	//+++++++++++++++++++++++++++
	//update Advert sequence
	//++++++++++++++++++++++++++

	public function update_advert_sequence($advert_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('advert_id' , $advert_id);
		$this->db->update('adverts', $data);	
	}
	
	//+++++++++++++++++++++++++++
	//update Ingredient sequence
	//++++++++++++++++++++++++++

	public function update_ingredient_sequence($ingredient_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('ingredient_id' , $ingredient_id);
		$this->db->update('recipe_ingredients', $data);	
	}		
	
	//+++++++++++++++++++++++++++
	//update Topic sequence
	//++++++++++++++++++++++++++

	public function update_topic_sequence($topic_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('topic_id' , $topic_id);
		$this->db->update('faq_topics', $data);	
	}		
	
	
	//+++++++++++++++++++++++++++
	//PAGES
	//++++++++++++++++++++++++++

	public function pages()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/pages/pages');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}

	//+++++++++++++++++++++++++++
	//add new page
	//++++++++++++++++++++++++++

	public function add_page()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/pages/add_page');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new page
	//++++++++++++++++++++++++++

	public function update_page($page_id)
	{
		if($this->session->userdata('admin_id')){
			
			$page = $this->admin_model->get_page($page_id);
			$page['settings'] = $this->get_config();
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/pages/update_page', $page);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$url = $this->input->post('url', TRUE);
			$feat_doc = $this->input->post('feat_doc', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$page_parent = $this->input->post('page_parent', TRUE);
			$page_template = $this->input->post('page_template', TRUE);
			$page_sequence = $this->input->post('page_sequence', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			 $bus_id = $this->session->userdata('bus_id');
		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages', 'add');
					
			}else{
				
				$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'pages', 'add');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'title'=> $title,
					  'heading'=> $heading,
					  'body'=> $body,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'slug'=> $slug,
					  'url'=> $url,
					  'document'=> $feat_doc,
					  'bus_id'=>$bus_id,
					  'page_parent'=> $page_parent,
					  'page_template'=> $page_template,
					  'page_sequence'=> $page_sequence
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('pages', $insertdata);
					$pageid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_page-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Page added successfully');
					$data['basicmsg'] = 'Page has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."admin/update_page/".$pageid."/';
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_page_do()
	{

		if($this->session->userdata('admin_id')){

			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$url = $this->input->post('url', TRUE);
			$icon = $this->input->post('icon', TRUE);
			$feat_doc = $this->input->post('feat_doc', TRUE);			
			$status = $this->input->post('status', TRUE);
			$page_downloads = $this->input->post('p_downloads', TRUE);
			$page_sidebars = $this->input->post('p_sidebars', TRUE);
			$page_people = $this->input->post('p_people', TRUE);
			
			
			$page_features = array();
			
			if($page_sidebars != "") {
				
				array_push($page_features, $page_sidebars);

			}
			
			if($page_downloads != "") {
				
				array_push($page_features, $page_downloads);
				
			}
			
			if($page_people != "") {
				
				array_push($page_features, $page_people);
				
			}			
			
			//print_r($page_features);
			
			$page_features = json_encode($page_features);
			
						
			
			//IE 9 FIX
			if($this->input->post('content')){
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			}else{
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content2', FALSE)));
			}
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('page_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
		 	$page_parent = $this->input->post('page_parent', TRUE);
			$page_sequence = $this->input->post('page_sequence', TRUE);
			$page_template = $this->input->post('page_template', TRUE);
			

			if($page_parent == 'Null') {
				$page_parent = 0;
			}

			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						  'title'=> $title ,
						  'status'=> strtolower($status),
						  'heading'=> $heading ,
						  'body'=> $body ,
						  'metaD'=> $metaD,
						  'metaT'=> $metaT,
						  'slug'=> $slug ,
						  'url'=> $url,
						  'icon'=> $icon,
						  'document'=> $feat_doc,								  
						  'bus_id'=>$bus_id,
						  'page_parent'=> $page_parent,
						  'page_features'=> $page_features,
						  'page_sequence'=> $page_sequence,
						  'page_template'=> $page_template
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id' , $id);
					$this->db->update('pages', $insertdata);
					//success redirect	
					$data['page_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_page-'. $id);
					
					
					
					$data['basicmsg'] = 'Page has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}

			//CACHING
			if($this->session->userdata('caching') == 'Y'){

				$url = $this->session->userdata('url');
				file_get_contents(prep_url($url).'/main/clean_cache/');
			}

		}else{

			echo "<script>var options = {'text':'Security credentials are outdated. Please refresh the page.','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}
	//DELETE PAGE
	function delete_page($page_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('page_id', $page_id);
			  $this->db->delete('pages');
			  //LOG
			  $this->admin_model->system_log('delete_page-'.$page_id);
			  $this->session->set_flashdata('msg','Page deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/pages/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//UPDATE PAGE LANGUAGES
	//++++++++++++++++++++++++++	
	function update_page_do_language($language)
	{
			$title = $this->input->post('title_'.$language, TRUE);
			$slug = $this->input->post('slug_'.$language, TRUE);
			$status = $this->input->post('status_'.$language, TRUE);
			//$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content_'.$language,FALSE)));
			$heading = $this->input->post('heading_'.$language, TRUE);
			$metaT = $this->input->post('metaT_'.$language, TRUE);
			$metaD = $this->input->post('metaD_'.$language, TRUE);
			$id = $this->input->post('page_id_'.$language, TRUE);

		 	$bus_id = $this->session->userdata('bus_id');
			$page_template = $this->input->post('page_template', TRUE);
		 
		 	if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
		 
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			


				$insertdata = array(
								  'title'=> $title ,
								  'status'=> strtolower($status),
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug ,
								  'bus_id'=>$bus_id,
								  'page_id'=> $id,
								  'page_template'=> $page_template
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id', $id);
					$hasrow = $this->db->get('pages_'.$language);
					//UPDATE
					if($hasrow->result()){
				
							$this->db->where('page_id' , $id);
							$this->db->update('pages_'.$language, $insertdata);
					//NEW	
					}else{
						
						
							$this->db->insert('pages_'.$language, $insertdata);
						
						
					}
		
					//success redirect	
					$data['page_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_page-'. $id);
					$data['basicmsg'] = 'Page has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";



					//CACHING
					if($this->session->userdata('caching') == 'Y'){

						$url = $this->session->userdata('url');
						file_get_contents(prep_url($url).'main/clean_cache/');
					}

					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}

	
	//+++++++++++++++++++++++++++
	//COMMENTS
	//++++++++++++++++++++++++++

	public function comments()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/comments');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE COMMENT
	function delete_comment($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $this->db->where('com_id', $id);
			  $this->db->delete('comments');
			  //LOG
			  $this->admin_model->system_log('delete_comment-'.$id);
			  $this->session->set_flashdata('msg','Comment deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/comments/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	//VIEW COMMENT
	function view_comment($id){

			  $this->db->where('com_id', $id);
			  $query = $this->db->get('comments');
			  
			  if($query->result()){
				  
					$row = $query->row();
					echo '<div class="well">'.$row->body.'<br /><br /><span style="font-size:10px">'.$row->name.'</span></div>';  
				  
			  }
						
	
    }
	//MODERATE COMMENT
	function update_comment_status($id, $status){

		if($this->session->userdata('admin_id')){
			
			  $data['status'] = $status;	
		 	  $this->db->where('com_id', $id);
			  $query = $this->db->update('comments', $data);
			  $this->session->set_flashdata('msg','Comment updated successfully');
					
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/comments/";
				  </script>';
			 
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		} 
			 
						
	
    }


	//+++++++++++++++++++++++++++
	//FAQ
	//++++++++++++++++++++++++++

	public function faq()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/faq/faq');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//ADD FAQ
	//++++++++++++++++++++++++++

	public function add_faq()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/faq/add_faq');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE FAQ
	//++++++++++++++++++++++++++

	public function update_faq($faq_id)
	{
		if($this->session->userdata('admin_id')){
			
			$faq = $this->admin_model->get_faq($faq_id);
			$this->load->view('admin/faq/update_faq', $faq);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD FAQ DO
	//++++++++++++++++++++++++++	
	function add_faq_do()
	{
			$topic = $this->input->post('topic', TRUE);
			$question = $this->input->post('question', TRUE);
			$answer = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('answer', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
			

			//VALIDATE INPUT
			if($question == ''){
				$val = FALSE;
				$error = 'Question Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
//					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
			$insertdata = array(
			  'topic_id'=> $topic ,
			  'question'=> $question,
			  'answer'=> $answer,
			  'bus_id'=> $bus_id
			);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('faq', $insertdata);
					$faqid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_faq-'.$question);
					//success redirect	
					$this->session->set_flashdata('msg','FAQ added successfully');
					$data['basicmsg'] = 'FAQ has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_faq/'.$faqid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	
		
	 //+++++++++++++++++++++++++++
	//UPDATE FAQ
	//++++++++++++++++++++++++++	
	function update_faq_do()
	{

			$status = $this->input->post('status', TRUE);
			$topic = $this->input->post('topic', TRUE);
			$question = $this->input->post('question', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$answer = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('answer', FALSE)));
			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('faq_id', TRUE);
		    
			
			
			//VALIDATE INPUT
			if($question == ''){
				$val = FALSE;
				$error = 'Question Required';

					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'status'=> strtolower($status),
					  'topic_id'=> $topic ,
					  'question'=> $question,
					  'answer'=> $answer,
					  'sequence'=> $sequence,
					  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('faq_id' , $id);
					$this->db->update('faq', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_faq-'. $id);
					$data['basicmsg'] = 'FAQ Entry has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	
	//DELETE FAQ
	function delete_faq($faq_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('faq_id', $faq_id);
			  $this->db->delete('faq');
			  //LOG
			  $this->admin_model->system_log('delete_faq-'.$post_id);
			  $this->session->set_flashdata('msg','FAQ entry deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/faq/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


		
	//+++++++++++++++++++++++++++
	//POSTS
	//++++++++++++++++++++++++++

	public function posts()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/posts');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//add new post
	//++++++++++++++++++++++++++

	public function add_post()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/add_post');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//update post
	//++++++++++++++++++++++++++

	public function update_post($post_id)
	{
		if($this->session->userdata('admin_id')){
			
			$post = $this->admin_model->get_post($post_id);
			$this->load->view('admin/posts/update_post', $post);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD POST DO
	//++++++++++++++++++++++++++	
	function add_post_do()
	{
			$title = $this->input->post('title', TRUE);
			$language = $this->input->post('language', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$post_template = $this->input->post('post_template', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		 
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'posts', 'add');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'posts', 'add');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
//					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				date_default_timezone_set('Africa/Windhoek');
				$time = date("r"); // local time

				$insertdata = array(
					  'title'=> $title ,
					  'heading'=> $heading ,
					  'body'=> $body ,
					  'language'=> $language,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  //'datetime'=> date('Y-m-d H:i:s'),
					  'datetime'=> date('Y-m-d H:i:s',strtotime($time)),
					  'slug'=> $slug,
					  'post_template'=> $post_template,
					  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('posts', $insertdata);
					$postid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_post-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Post added successfully');
					$data['basicmsg'] = 'Post has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_post/'.$postid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_post_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$language = $this->input->post('language', TRUE);
			$status = $this->input->post('status', TRUE);
			$comments = $this->input->post('comments', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('post_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
		    $bus_id = $this->session->userdata('bus_id');
			$post_template = $this->input->post('post_template', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'posts');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'posts');
				
			}
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'title'=> $title ,
					  'status'=> strtolower($status),
					  'comments'=> strtolower($comments),
					  'heading'=> $heading ,
					  'language'=> $language ,
					  'body'=> $body ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'datetime  '=> date('Y-m-d H:i:s',strtotime($pubdate)),
					  'slug'=> $slug,
					  'post_template'=> $post_template,
					  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('post_id' , $id);
					$this->db->update('posts', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_post-'. $id);
					$data['basicmsg'] = 'Post has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//DELETE POST
	function delete_post($post_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('post_id', $post_id);
			  $this->db->delete('posts');
			  //LOG
			  $this->admin_model->system_log('delete_post-'.$post_id);
			  $this->session->set_flashdata('msg','Post deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/posts/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	
	//+++++++++++++++++++++++++++
	//add new publication
	//++++++++++++++++++++++++++

	public function add_publication()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/publications/add_pub');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//update publication
	//++++++++++++++++++++++++++

	public function update_publication($pub_id)
	{
		if($this->session->userdata('admin_id')){
			
			$pub = $this->admin_model->get_publication($pub_id);
			$this->load->view('admin/publications/update_pub', $pub);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD PUBLICATION DO
	//++++++++++++++++++++++++++	
	function add_publication_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$link = $this->input->post('link', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$issue_date = $this->input->post('issue_date', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		 
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications', 'add');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Publication title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
//					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title,
								  'body'=> $body,
								  'link'=> $link,
								  'issue_date'=> $issue_date,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('publications', $insertdata);
					$pubid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_publication-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Publication added successfully');
					$data['basicmsg'] = 'Publication has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_publication/'.$pubid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PUBLICATION
	//++++++++++++++++++++++++++	
	function update_publication_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$link = $this->input->post('link', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$issue_date = $this->input->post('issue_date', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			$pub_id = $this->input->post('pub_id', TRUE);
			$status = $this->input->post('status', TRUE);
		    
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications');
					
			}else{

				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');
				
			}
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Publication title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'status'=> strtolower($status),
								  'body'=> $body ,
								  'link'=> $link,
								  'issue_date'=> $issue_date,								  
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug,
								  'bus_id'=> $bus_id 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('pub_id' , $pub_id);
					$this->db->update('publications', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_publication-'. $pub_id);
					$data['basicmsg'] = 'Publication has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}	
	
	
	
	
	//DELETE PUBLICATION
	function delete_publication($pub_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('pub_id', $pub_id);
			  $this->db->delete('publications');
			  //LOG
			  $this->admin_model->system_log('delete_publication-'.$pub_id);
			  $this->session->set_flashdata('msg','Publication deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/publications/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	public function home2()
	{

		$this->load->library('ga_api');

		// Set new profile id if not the default id within your config document
		$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));
		
		// Query Google metrics and dimensions
		// Documentation: http://code.google.com/apis/analytics/docs/gdata/dimsmets/dimsmets.html)
		$data = $this->ga_api->login()
			->dimension('date')
			->metric('visitors, visits')
			->when('1 month ago', 'yesterday')
			->get_array();
		
		// Also please note, if you using default values you still need to init()

   		// Also please note, if you using default values you still need to init()
		$c = 0;$x = 0;
		foreach($data as $key => $value){
				   if($key != 'summary'){	
						$comma = ',';
								 
						if($c == 29){
							$comma = '';
						 }
							   
						 $final = $value['visitors'];
						
						 echo '['.$c.', ' .$final. ']'.$comma;
						 $c ++;
				   }
				}
		echo 'TOTAL: ' .$x .' Total records: '.$c;
		var_dump($data);
	}
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{
		
			//$this->session->sess_destroy();
			
			$email = $this->input->post('email', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			
			
			//MATCH CREDENTIALS
			$row = $this->admin_model->validate_password($email,$pass);
			if($row['bool'] == TRUE){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->admin_model->hash_password($email,$pass);
					//create user array
					 $data = array(
					  /* 'user_agent' => $this->agent->browser() . ' ver ' . $this->agent->version(),*/
					   'last_login' => date("Y-m-d H:i:s"),
					   'pass' => $pass_new
					);
					
					if ($sess == TRUE) {
					//$this->session->cookie_monster();	
					}
					//GET SETTINGS
					
					$query = $this->db->where('bus_id', $row['bus_id']);
					$query = $this->db->get('settings');
					$settings = $query->row_array();
					
					$sess_array = array(
						'admin_id' => $row['admin_id'],
						'bus_id' => $row['bus_id'],
						'u_name' => $row['fname'],
						'full_name' => $row['fname'].''.$row['sname'],
						'last_login' => $row['last_login'],
						'GA_profile' => $settings['GA_profile'],
						'GA_email' =>  $settings['GA_email'],
						'GA_pass' => $settings['GA_pass'],
						'site_title' => $settings['title'],
						'url' => $settings['url'],
						'img_file' => $row['img_file'],
						'role' => $row['type'],
						'caching' => $settings['caching']

					);
					
					
					$this->session->set_userdata($sess_array);

					$this->db->where('admin_id', $row['admin_id']);
					$this->db->update('admin', $data);
					
					//LOG
					$this->admin_model->system_log('system_log_in-'. $row['fname']) ;
					//DISPLAY Settings incomplete
					if($this->session->userdata('url') == ''){
						
						$this->session->set_flashdata('error', 'Website settings incomplete. Please update your settings');
							
					}

					$this->session->set_flashdata('msg', 'Logged in successful. Last login was on ' .date('l jS \of F Y h:i:s A',strtotime($row['last_login'])));
					//--------------
					//Redirect
					if($this->input->post('redirect')){

						if(strpos($redirect, 'login') !== false){

							redirect(site_url('/').'admin/home/', '301');

						}else{

							redirect($redirect, '301');

						}

						
					}else{
						

						redirect(site_url('/').'admin/home/', '301');	
						
					}
				
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No matching records found!';
				//echo $this->encode($pass) .' ' ;
				$this->load->view('admin/login' , $data);
			
			}
				
	}


	function logout(){

		$this->session->sess_destroy();  
		redirect(site_url('/'),'301');
		//$this->index();
	}


	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BACKBONE AJAX CALLS
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
 */	
	//GET USERS	
	function get_pages(){

		
		$this->admin_model->get_pages();
	

	}	
	
	
	
	//+++++++++++++++++++++++++++
	//ADD SUBSCRIBER CATEGORIES
	//++++++++++++++++++++++++++

	public function add_sub_type_do()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['type'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;

		//TEST DUPLICATE CATEGORIES
		$this->db->where('type', $data['type']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('subscriber_type');
		
		if($result1->num_rows() == 0){
			$this->db->insert('subscriber_type', $data);	
		}

		
		
	}

	//+++++++++++++++++++++++++++
	//LOAD MARATHON SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_marathon_members($type)
	{
		$this->load->model('marathon_model');
		$this->marathon_model->get_all_members($type);
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD AEP SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_aep_members($type)
	{
		$this->load->model('aep_model');
		$this->aep_model->get_all_members($type);	
	}	
	
	
	//+++++++++++++++++++++++++++
	//LOAD SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_members($type)
	{
		$this->load->model('members_model');
		$this->members_model->get_all_members($type);
		
	}
	//+++++++++++++++++++++++++++
	//LOAD COST DASHBOARD SMS
	//++++++++++++++++++++++++++

	public function ajax_load_cost_dashboard($type = '')
	{
		$this->load->model('sms_model');
		$this->sms_model->cost_dashboard($type);

	}

	//+++++++++++++++++++++++++++
	//LOAD EMAIL SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_subscribers($type = '', $sub_cat = '')
	{
		$this->load->model('email_model');
		$this->email_model->show_email_recipients($type, $sub_cat);

	}
	//+++++++++++++++++++++++++++
	//LOAD EMAIL SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function find_subscribers($type = '', $sub_cat = '')
	{

		$this->load->model('email_model');
		$this->email_model->find_subscribers($type, $sub_cat);

	}

	//+++++++++++++++++++++++++++
	//LOAD SMS SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_sms_subscribers($type = '', $sub_cat = '')
	{
		$this->load->model('sms_model');
		$this->sms_model->show_sms_recipients($type, $sub_cat);

	}

	//+++++++++++++++++++++++++++
	//RELOAD SUBSCRIBER TYPES
	//++++++++++++++++++++++++++

	public function reload_sub_category_all()
	{
		$this->admin_model->get_all_sub_categories();
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE SUBSCRIBER CATEGORY
	//++++++++++++++++++++++++++

	public function delete_subscriber_category($id)
	{
		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('sub_type_id', $id);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('subscriber_type');
		
	}



	//+++++++++++++++++++++++++++
	//TOPICS
	//++++++++++++++++++++++++++

	public function faq_topics()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/faq/topics');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//ADD FAQ TOPIC
	//++++++++++++++++++++++++++

	public function add_faq_topic()
	{
		$bus_id = $this->session->userdata('bus_id');		
		//INSERT INTO TOPICS
		$data['topic'] = $this->input->post('topic');
		$data['bus_id'] = $bus_id;
		
		//TEST DUPLICATE CATEGORIES
		$this->db->where('topic', $data['topic']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('faq_topics');
		
		if($result1->num_rows() == 0){
			$this->db->insert('faq_topics', $data);	
		}

		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD FAQ TOPICS ALL
	//++++++++++++++++++++++++++

	public function reload_faq_topics_all()
	{
		$this->admin_model->get_all_topics();
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE TOPIC
	//++++++++++++++++++++++++++

	public function delete_topic($id)
	{
		$this->db->where('topic_id', $id);
		$this->db->delete('faq_topics');
		
	}	
	
	







	//+++++++++++++++++++++++++++
	//CHART CATEGORIES
	//++++++++++++++++++++++++++

	public function chart_categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('chart_model');
			$this->load->view('admin/charts/categories');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//ADD CHART CATEGORY
	//++++++++++++++++++++++++++

	public function add_chart_category()
	{
		$bus_id = $this->session->userdata('bus_id');	
			
		//INSERT INTO TOPICS
		$data['title'] = $this->input->post('category');
		$data['bus_id'] = $bus_id;
		
		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('chart_categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('chart_categories', $data);	
		}

		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CHART CATEGORIES ALL
	//++++++++++++++++++++++++++

	public function reload_chart_categories_all()
	{
		$this->load->model('chart_model'); 
		$this->chart_model->get_all_categories();
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE CHART CATEGORY
	//++++++++++++++++++++++++++

	public function delete_chart_category($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('chart_categories');
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY AND INTERSECTION FOR POST
	//++++++++++++++++++++++++++

	public function add_category_do()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('categories');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('post_id', $post_id);
		$result = $this->db->get('post_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['cat_id'] = $row['cat_id'];
			$data2['post_id'] = $post_id;	
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('post_cat_int', $data2);	
		}
		
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY GENERLA
	//++++++++++++++++++++++++++

	public function add_category_do_general()
	{
		 $bus_id = $this->session->userdata('bus_id');		
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('categories');
		$row = $result->row_array();

		
	}

	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->admin_model->get_all_categories();
		
	}
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY
	//++++++++++++++++++++++++++

	public function reload_category($post_id)
	{
		$this->admin_model->get_categories_current($post_id);
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY INTERSECTION
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('post_cat_int');
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MAIN
	//++++++++++++++++++++++++++

	public function delete_category_main($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('categories');
		
	}
	//+++++++++++++++++++++++++++
	//Load CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/categories');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	
	 //+++++++++++++++++++++++++++
	//Load USERS
	//++++++++++++++++++++++++++

	public function users()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/users');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	//GET USER
	function get_sys_user($id){

		$this->db->where('admin_id', $id);
		$query = $this->db->get('admin');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="user-update" name="user-update" method="post" action="'.site_url('/').'admin/update_sys_user_do" class="form-horizontal">
    						<input type="hidden" id="user_id" name="user_id" value="'.$row['admin_id'].'">  
							<div class="control-group">
								  <label class="control-label" for="uname">First Name</label>
								<div class="controls">
								   <input type="text" id="uname" name="uname" placeholder="First Name" value="'.$row['fname'].'">                    
								</div>
				  </div>
							 <div class="control-group">
								  <label class="control-label" for="sname">Surname</label>
								<div class="controls">
								   <input type="text" id="sname" name="sname" placeholder="Surname" value="'.$row['sname'].'">                    
								</div>
							 </div>
							  <div class="control-group">
								  <label class="control-label" for="uposition">User Rights</label>
								<div class="controls">
									<select name="uposition" id="uposition">
									  <option value="editor">Editor</option>
									  <option value="admin">Admin</option>
									 
									</select>                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uemail">User Email</label>
								<div class="controls">
								   <input type="text" id="uemail" name="uemail" placeholder="User Email" value="'.$row['email'].'">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uuserpass">User Password</label>
								<div class="controls">
								   <input type="password" id="uuserpass" name="uuserpass" placeholder="User Password" value="">                    
								</div>
							 </div>  
							   
								
						</form>';
					

			}else{
					
				$this->session->set_flashdata('error', 'User not found');	
			}
	}
	
	
	//ADD	
	function add_sys_user_do(){
			
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('position', TRUE);
			$pass = $this->input->post('userpass', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');
			//TEST IF EXISTING
			$this->db->where('email', $email);
			$query = $this->db->get('admin');
			//EMAIL EXISTS
			if($query->result()){
				
				$this->session->set_flashdata('error', 'Email addres already in use');		

			}else{
					
				$insertdata = array(
								  'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  'bus_id'=> $bus_id,
								  'pass'=> $this->admin_model->hash_password($email,$pass)
					);
					$this->db->insert('admin',$insertdata);
					$this->session->set_flashdata('msg', 'Successfully added system user');	
			}
			


	}
	//UPDATE	
	function update_sys_user_do(){
			
			$email = $this->input->post('uemail', TRUE);
			$name = $this->input->post('uname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('uposition', TRUE);
			$pass = $this->input->post('uuserpass', TRUE);
			$id = $this->input->post('user_id', TRUE);
			
			if($pass == ''){
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position
					);
				
				
				
			}else{
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  
								  'pass'=> $this->admin_model->hash_password($email,$pass)
					);
				
				
			}
			
			  $this->db->where('admin_id', $id);
			  $this->db->update('admin',$insertdata);
			  $this->session->set_flashdata('msg', 'Successfully updated system user');	
			


	}
	
	
	
	//+++++++++++++++++++++++++++
	//DELETE USER
	//++++++++++++++++++++++++++

	public function delete_user($id)
	{
		$this->db->where('admin_id', $id);
		$this->db->delete('admin');
		//LOG
		$this->admin_model->system_log('delete-system-user'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted system user');	
	}
	
	//+++++++++++++++++++++++++++
	//SETTINGS
	//++++++++++++++++++++++++++

	public function settings()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('my_namibia_model');
			$settings = $this->admin_model->get_settings();
			$this->load->view('admin/settings', $settings);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE SETTINGS
	//++++++++++++++++++++++++++	
	function update_settings_do()
	{
			$title = $this->input->post('title', TRUE);
			$description = $this->input->post('metaD', TRUE);
			$cemail = $this->input->post('contact_email', TRUE);
			$ga_id = $this->input->post('ga_id', TRUE);
			$ga_email = $this->input->post('ga_email', TRUE);
			$ga_pass = $this->input->post('ga_pass', TRUE);
			$id = $this->input->post('set_id', TRUE);
			$url = prep_url($this->input->post('url', TRUE));

			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Website title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(strip_tags($description) == ''){
				$val = FALSE;
				$error = 'Website description or tagline Required';	
							
			}else{
				$val = TRUE;
			}



			$insertdata = array(
							  'title'=> $title ,
							  'GA_profile'=> $ga_id,
							  'GA_email'=> $ga_email ,
							  'contact_email'=> $cemail ,
							  'description'=> $description,
							  'url'=> $url

			);

			if($ga_pass != ''){

				$insertdata['GA_pass'] = $ga_pass;

			}
	
			
			if($val == TRUE){
				
					$this->db->where('set_id' , $id);
					$this->db->update('settings', $insertdata);
					//success redirect	
					$this->session->set_userdata('GA_profile', $ga_id);
					$this->session->set_userdata('GA_email',  $ga_email);
					$this->session->set_userdata('GA_pass',$ga_pass);
					$this->session->set_userdata('site_title',$title);
					$this->session->set_userdata('url',$url);
					//LOG
					$this->admin_model->system_log('update_settings-'. $id);
					$data['basicmsg'] = 'Settings have been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//+++++++++++++++++++++++++++
	//CONTACT FORM SUBMISSIONS
	//++++++++++++++++++++++++++

	public function enquiries()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/enquiries');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//DELETE ENQUIRY
	//++++++++++++++++++++++++++

	public function delete_enquiry($id)
	{
		$this->db->where('enq_id', $id);
		$this->db->delete('enquiries');
		//LOG
		$this->admin_model->system_log('delete-enquiry'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted the enquiry');	
	}
	

	//+++++++++++++++++++++++++++
	//RELOAD CHAT ALL
	//++++++++++++++++++++++++++

	public function reload_chat_all($ticket)
	{
		$this->admin_model->get_chat_content($ticket);
		
	}	

	public function helpdesk()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/helpdesk');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}	


	
	//+++++++++++++++++++++++++++
	//HELPDESK
	//++++++++++++++++++++++++++
	public function support_chat($ticket)
	{	
		if($this->session->userdata('admin_id')){
		$bus_id = $this->session->userdata('bus_id');
			
		$data['ticket'] = $ticket;
		
		$insertdata = array('status'=> 'active');	
		
		$this->db->where('bus_id' , $bus_id);
		$this->db->where('ticket_id' , $ticket);
		$this->db->update('support_tickets', $insertdata);		
		
		$this->load->view('admin/support_chat', $data);
		
		}else{
			
			$this->load->view('admin/login');
			
		}			
		
		
	}	
	
		
	public function add_quick_message()
	{
			
		$this->admin_model->add_quick_message();
		
		
	}
	
	public function close_ticket($ticket)
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$insertdata = array('status'=> 'closed');
	
		$this->db->where('bus_id' , $bus_id);
		$this->db->where('ticket_id' , $ticket);
		$this->db->update('support_tickets', $insertdata);
				
		$this->load->view('admin/helpdesk');
		
		
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE SUBSCRIBERS
	//++++++++++++++++++++++++++	
	function delete_ticket($ticket){
      	
		  $query = $this->db->where('ticket_id', $ticket);
		  $this->db->delete('support_tickets');
		  
		  $query2 = $this->db->where('ticket_id', $ticket);
		  $this->db->delete('live_chat');			  
		  
		  $this->admin_model->system_log('delete_ticket-'.$ticket);
		  $this->session->set_flashdata('msg','Ticket deleted successfully');
							
    }			
	
	//+++++++++++++++++++++++++++
	//GET ENQUIRY
	//++++++++++++++++++++++++++

	public function get_enquiry($id)
	{
		$this->db->where('enq_id', $id);
		$query = $this->db->get('enquiries');

			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<div id="reply_view"><p>'.$row['name'].'</p>';
				echo '<div class="well">'.$row['body'].'</div>';	
				echo '<em>'.date('l jS \of F Y h:i:s A',strtotime($row['datetime'])).'</em></div>';
				
				echo '<div id="reply_txt" class="hide" style="margin-top:30px;">
						  <form id="sendmail" onsubmit="return validateMyForm();" name="sendmail" method="post" action="'.site_url('/').'admin/reply_enquiry" >
							  <input type="hidden" id="" name="name" value="'.$row['name'].'">
							  <input type="hidden" id="" name="enq_id" value="'.$id.'">
							  <input type="hidden" id="" name="email" value="'.$row['email'].'">
							  <textarea id="redactor_content" class="redactor" name="content"><p>&nbsp</p><p>--------------------------</p>
							  <p>From: '.$row['name'].'</p><p>'.$row['body'].'</p><em> Time: '.date('l jS \of F Y h:i:s A',strtotime($row['datetime'])).'</em>
							  <p>--------------------------</p></textarea>
							  <div class="clearfix" style="height:20px;"></div>
							  <div id="reply_msg"></div>
							  <button type=button" onclick="reply_enquiry()" id="send_mail_btn" class="btn pull-right"><i class="icon-envelope"></i> Send</button>
						  </form>
						  <script type="text/javascript">
						  			
									function validateMyForm()
									{
									 	return false;
									 	//reply_enquiry();
									 
									}
									console.log("poes");
									$(".redactor").redactor({ 	
												
												imageGetJson: "' .site_url('/').'my_images/show_upload_images_json/",
												imageUpload: "'.site_url('/').'my_images/redactor_add_image",
												buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
												"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
												"video", "table", "link","|",
												 "alignment", "|", "horizontalrule"]
									});
						  
						  </script>
					  </div>
					  ';	  
				
				
			}else{
					
				$this->session->set_flashdata('error', 'Enquiry not found');	
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//REPLY ENQUIRY
	//++++++++++++++++++++++++++

	public function reply_enquiry()
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->reply_enquiry();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	
	
		//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function bookings()
	{
		if($this->session->userdata('admin_id')){
			

			$this->load->view('admin/bookings/bookings', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE IMAGE
	function delete_booking($booking_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('booking_id', $booking_id);
			  $this->db->delete('bookings');
			  //LOG
			  $this->admin_model->system_log('delete_booking-'.$booking_id);
			  $this->session->set_flashdata('msg','Booking removed from system');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/bookings/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE BOOKING
	//++++++++++++++++++++++++++

	public function update_booking($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'members');
			$member['member_type'] = 'members';
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//MODERATE BOOKINGS
	function update_booking_status($id, $status, $type){

		if($this->session->userdata('admin_id')){

			  $data[$type] = $status;	
		 	  $this->db->where('booking_id', $id);
			  $query = $this->db->update('bookings', $data);
			  $this->session->set_flashdata('msg','Booking updated successfully');
					
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/bookings/";
				  </script>';
			 
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		} 
			 
						
	
    }
	
	//+++++++++++++++++++++++++++
	//ADD NSA DOC
	//++++++++++++++++++++++++++

	public function add_nsa_doc()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('nsa_pub_model');
			$this->nsa_pub_model->add_nsa_doc();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}



	//+++++++++++++++++++++++++++
	//REMOVE NSA DOC
	//++++++++++++++++++++++++++
	public function remove_featured_document($id, $typ)
	{
		$this->load->model('nsa_pub_model');
		$this->nsa_pub_model->remove_featured_document($id, $typ);

	}
	//+

	
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function add_featured_image()
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->add_featured_image();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function add_featured_image_external()
	{

		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'application/json' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "GET")
		{
			

			$this->admin_model->add_featured_image();
		}






	}
	public function add_featured_logo()
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->add_featured_logo();

		}else{

			redirect(site_url('/').'admin/logout');

		}


	}


	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function remove_featured_image($type, $id)
	{
		$this->db->where('type', $type);
		$this->db->where('type_id', $id);
		$query = $this->db->get('images');
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('type', $type);
		    $this->db->where('type_id', $id);
			$this->db->delete('images');
			 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Image removed.','layout':'bottomLeft','type':'success'};
					  noty(options);
					
					  </script>";		 
						 	
			
		}
	}
	//+++++++++++++++++++++++++++
	//SMS MARKETING
	//++++++++++++++++++++++++++

	public function sms_marketing()
	{

		if($this->session->userdata('admin_id')){
			
			$this->load->model('sms_model');
			$this->load->view('admin/sms/sms_marketing');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//SMS MARKETING - COMPOSE
	//++++++++++++++++++++++++++

	public function compose_sms($id = 0)
	{

		if($this->session->userdata('admin_id')){

			if($id == 0){

				$email = '';
			}else{

				$this->db->where('sms_id', $id);
				$q = $this->db->get('sms');

				if($q->result()){

					$email = $q->row_array();
				}

			}

			$this->load->model('sms_model');
			$val = $this->sms_model->check_credit();
			if($val['bool']){

				$this->load->view('admin/sms/compose_sms', $email);
			}else{

				echo $val['error'];
			}



		}else{

			$this->load->view('admin/login');

		}


	}
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING PREVIEW EMAIL
	//++++++++++++++++++++++++++

	public function preview_sms()
	{

		if($this->session->userdata('admin_id')){


			$data['preview'] = 'true';
			//$data['body'] = html_entity_decode($this->input->post('mailbody', TRUE));
			$data['body'] = $this->input->post('mailbody', FALSE);
			//$data['body'] = urldecode($body);

			$this->load->view('email/sms_body', $data);


		}else{

			echo '<div class="alert">PLease login to continue</div>';

		}


	}

	//+++++++++++++++++++++++++++
	//SMS MARKETING SAVE EMAIL
	//++++++++++++++++++++++++++
	function save_sms(){

		//TEST ROLE
		if(!$this->session->userdata('admin_id')){

			$this->session->set_flashdata('error', 'You do not have access!');
			redirect('/admin/home', 'refresh');
			die();

		}
		$subject = $this->input->post('title',TRUE);
		$body = $this->input->post('content',FALSE);
		$type = $this->input->post('stype',FALSE);
		$sms_id = $this->input->post('sms_id',FALSE);

		$data['title'] = $subject;
		$data['bus_id'] = $this->session->userdata('bus_id');
		$data['body'] = $body;
		$data['status'] = 'draft';
		$data['admin_id'] = $this->session->userdata('admin_id');

		if($sms_id == 0){

			$this->db->insert('sms', $data);
			$email_id = $this->db->insert_id();

		}else{

			$this->db->where('sms_id', $sms_id);
			$this->db->update('sms', $data);

		}

		echo '<script type="text/javascript"> $("#sms_id").val("'.$sms_id.'");</script>';




	}
	//+++++++++++++++++++++++++++
	//SMS MARKETING GET LIST EMAIL
	//++++++++++++++++++++++++++

	public function get_smss($status = '')
	{

		$this->load->model('sms_model');
		$this->sms_model->get_sms($status);
	}
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING DELETE EMAIL
	//++++++++++++++++++++++++++

	public function delete_sms($id)
	{
		if($this->session->userdata('admin_id'))
		{

			$this->db->where('sms_id', $id);
			$this->db->where('bus_id', $this->session->userdata('bus_id'));
			$this->db->delete('sms');
		}
	}

	//+++++++++++++++++++++++++++
	//SMS MARKETING SEND SMS
	//++++++++++++++++++++++++++

	public function send_sms()
	{

		$this->load->model('sms_model');
		$this->sms_model->send_sms();
	}

	//+++++++++++++++++++++++++++
	//SMS MARKETING SMS LOGS
	//++++++++++++++++++++++++++

	public function load_sms_logs($id = '')
	{
		$this->load->model('sms_model');
		$this->sms_model->load_sms_logs($id);
	}






	//+++++++++++++++++++++++++++
	//EMAIL MARKETING
	//++++++++++++++++++++++++++

	public function email_marketing()
	{

		if($this->session->userdata('admin_id')){

			$this->load->model('email_model');
			$this->load->view('admin/email/email_marketing');

		}else{

			$this->load->view('admin/login');

		}


	}



	//+++++++++++++++++++++++++++
	//EMAIL MARKETING - GET INCOMING
	//++++++++++++++++++++++++++

	public function get_incoming_sms()
	{

		$this->load->model('sms_model');
		$this->sms_model->get_incoming();



	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING - GET PROMO
	//++++++++++++++++++++++++++

	public function get_promo_update($id)
	{

		$this->load->model('sms_model');
		$this->sms_model->get_promo_update($id);



	}

	function do_promo_update($id){


		if($this->session->userdata('admin_id'))
		{

			$data['sms_promo_id'] = $id;
			$data['response'] = $this->input->post('response');
			$data['is_active'] = $this->input->post('is_active');
			$sms_promo_id = $this->input->post('sms_promo_id');
			$data['type'] = $this->input->post('type');

			$this->db->where('sms_promo_id', $sms_promo_id);
			$this->db->update('sms_promo', $data);

		}else{

			echo "<script>var options = {'text':'Please Log in again to continue','layout':'bottomLeft','type':'error'};
				   noty(options);</script>";

		}


	}


	//+++++++++++++++++++++++++++
	//EMAIL MARKETING - COMPOSE
	//++++++++++++++++++++++++++

	public function compose_email($id = 0)
	{

		if($this->session->userdata('admin_id')){

			if($id == 0){

				$email = '';
			}else{

				$this->db->where('email_id', $id);
				$q = $this->db->get('emails');

				if($q->result()){

					$email = $q->row_array();
				}

			}

			$this->load->model('email_model');
			$this->load->view('admin/email/compose_email', $email);

		}else{

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING PREVIEW EMAIL
	//++++++++++++++++++++++++++

	public function test_email()
	{

		$this->load->view('email/body_news_new');
	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING PREVIEW EMAIL
	//++++++++++++++++++++++++++

	public function preview_email()
	{
		
		if($this->session->userdata('admin_id')){


			$data['preview'] = 'true';
			//$data['body'] = html_entity_decode($this->input->post('mailbody', TRUE));
			$data['body'] = $this->input->post('mailbody', FALSE);
			//$data['body'] = urldecode($body);

			$this->db->where('bus_id', $this->session->userdata('bus_id'));
			$q = $this->db->get('email_templates');

			if($q->result()){

				$row = $q->row();

				//SNIPPEt
				$snippet = $this->admin_model->shorten_string(strip_tags($data['body']), 18);

				//REPLACE snippet and Link with dynamic content
				//teaser
				$header = str_replace('{{teaser}}', $snippet, $row->header);
				$out = $header;
				$out .= $data['body'];
				$out .= $row->footer;

				echo $out;

			}else{

				$this->load->view('email/body_news', $data);

			}



		}else{

			echo '<div class="alert">PLease login to continue</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//EMAIL MARKETING BUILD CONTENT
	//++++++++++++++++++++++++++
	function build_email_content($type = '', $id = '')
	{
		$this->load->model('email_model');

		$this->email_model->build_email_content($type , $id);

	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING BUILD CMS CONTENT
	//++++++++++++++++++++++++++
	function build_cms_email_content($type = '', $id = '')
	{
		$this->load->model('email_model');

		$this->email_model->build_cms_email_content($type , $id);

	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING SAVE EMAIL
	//++++++++++++++++++++++++++
	function save_email(){

		//TEST ROLE
		if(!$this->session->userdata('admin_id')){

			$this->session->set_flashdata('error', 'You do not have access!');
			redirect('/admin/home', 'refresh');
			die();

		}
		$subject = $this->input->post('title',TRUE);
		$body = $this->input->post('content',FALSE);
		$type = $this->input->post('stype',FALSE);
		$email_id = $this->input->post('email_id',FALSE);

		$attachment = $this->input->post('byte_content',FALSE);
		$mime = $this->input->post('mime',FALSE);
		$file_name = $this->input->post('file_name',FALSE);

		$data['title'] = $subject;
		$data['bus_id'] = $this->session->userdata('bus_id');
		$data['body'] = $body;

		$data['attachment'] = $attachment;
		$data['file_name'] = $file_name;
		$data['mime'] = $mime;

		$data['admin_id'] = $this->session->userdata('admin_id');

		if($email_id == 0){
            $data['status'] = 'draft';
			$this->db->insert('emails', $data);
			$email_id = $this->db->insert_id();

		}else{

			$this->db->where('email_id', $email_id);
			$this->db->update('emails', $data);

		}

		echo '<script type="text/javascript"> $("#email_id").val("'.$email_id.'");</script>';




	}


	//+++++++++++++++++++++++++++
	//EMAIL MARKETING GET LIST EMAIL
	//++++++++++++++++++++++++++

	public function get_emails($status = '')
	{

		$this->load->model('email_model');
		$this->email_model->get_emails($status);
	}
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING DELETE EMAIL
	//++++++++++++++++++++++++++

	public function delete_email($id)
	{
		if($this->session->userdata('admin_id'))
		{

			$this->db->where('email_id', $id);
			$this->db->where('bus_id', $this->session->userdata('bus_id'));
			$this->db->delete('emails');
		}
	}
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING SEND EMAIL
	//++++++++++++++++++++++++++

	public function send_email()
	{
		
		$this->load->model('email_model');
		$this->email_model->send_email();
	}





	public function load_email_logs($id = '')
	{
		$this->load->model('email_model');
		$settings = $this->admin_model->get_settings();

		if($id != ''){

			$this->db->where('email_id', $id);
			$q = $this->db->get('emails');

			$str = 'Email logs for: ';

			if($q->result()){

				$row = $q->row();

				$query = 'subject:"'.$row->title.'"';
				$str = 'Email logs for: '.$row->title;
			}



		}else{

			$str = 'All Email logs';
			$query = '*';
		}

		//echo '<pre>' .$settings['contact_email'].'</pre>';
		echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>'.$str.'</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content">
			<div class="clearfix" style="width:100%"></div>';
		//$senders = array($settings['contact_email'])
		$this->email_model->get_email_logs($query , $date_from = '', $date_to = '', $tags = array(), $senders = array(), $limit = 1000);

		echo '</div></div>';
	}


    public function load_email_stats($id = '')
    {
        $this->load->model('email_model');
        $settings = $this->admin_model->get_settings();

        $q = $this->db->get('emails');

        $str = 'Email logs for: ';

        $emails = array();
        $emailsA = array();
        $x = 0;
        if($q->result()){

            //loop each
            foreach($q->result() as $erow){

                $t = 'email_id_'.$erow->email_id;

                $emailsA[$t]['email_id'] = $t;
                $emailsA[$t]['opens'] = $erow->opens;
                $emailsA[$t]['unique_opens'] = $erow->unique_opens;
                $emailsA[$t]['clicks'] = $erow->clicks;
                $emailsA[$t]['unique_clicks'] = $erow->unique_clicks;
                $emailsA[$t]['sends'] = $erow->sends;
                $emailsA[$t]['soft_bounces'] = $erow->soft_bounces;
                $emailsA[$t]['hard_bounces'] = $erow->hard_bounces;
                $emailsA[$t]['unsubscribes'] = $erow->unsubscribes;
                $emailsA[$t]['complaints'] = $erow->complaints;
                array_push($emails, $t);
                //array_push($emailsA, $erow);
                $x ++;
            }


        }

        var_dump($emails);


        $x2 = 0;
        $result = $this->email_model->get_email_stats($query , $date_from = '', $date_to = '', $tags = array(), $senders = array($settings['contact_email']), $limit = 1000);

        if(count($result) > 0){

            foreach($result as $row){

                if(in_array($row['tag'], $emails)){

                    //COMPARE EXISTING
                    if($emailsA[$row['tag']]['sends'] < $row['sent']){

                        $insert['sends'] = $row['sent'];

                    }
                    if($emailsA[$row['tag']]['opens'] < $row['opens']){

                        $insert['opens'] = $row['opens'];

                    }
                    if($emailsA[$row['tag']]['unique_opens'] < $row['unique_opens']){

                        $insert['unique_opens'] = $row['unique_opens'];

                    }
                    if($emailsA[$row['tag']]['unique_clicks'] < $row['unique_clicks']){

                        $insert['unique_clicks'] = $row['unique_clicks'];

                    }
                    if($emailsA[$row['tag']]['clicks'] < $row['clicks']){

                        $insert['clicks'] = $row['clicks'];

                    }
                    if($emailsA[$row['tag']]['complaints'] < $row['complaints']){

                        $insert['complaints'] = $row['complaints'];

                    }
                    if($emailsA[$row['tag']]['unsubscribes'] < $row['unsubs']){

                        $insert['unsubscribes'] = $row['unsubs'];

                    }
                    if($emailsA[$row['tag']]['reputation'] < $row['reputation']){

                        $insert['reputation'] = $row['reputation'];

                    }
                    if($emailsA[$row['tag']]['rejects'] < $row['rejects']){

                        $insert['rejects'] = $row['rejects'];

                    }
                    if($emailsA[$row['tag']]['soft_bounces'] < $row['soft_bounces']){

                        $insert['soft_bounces'] = $row['soft_bounces'];

                    }
                    if($emailsA[$row['tag']]['hard_bounces'] < $row['hard_bounces']){

                        $insert['hard_bounces'] = $row['hard_bounces'];

                    }

                    $clean_id = str_replace('email_id_', '' , $row['tag']);

                    //$this->db->where('email_id', $clean_id);
                    //$this->db->update('emails', $insert);
                    echo 'Existing Sends: '.$emailsA[$row['tag']]['sends'] . '  -  API Sends: '.$row['sent']. ' ';
                    echo 'Wohoo ' .$row['tag']. ' - <br />';

                }

                //echo $row['tag']. ' - ';
                //var_dump($row);


            }



        }



    }

    //+++++++++++++++++++++++++++
    //TEST MANDRILL WEBHOOK
    //++++++++++++++++++++++++++

    public function webhook()
    {

        $o = '[{"event":"send","_id":"301ba728c2ad4cd7bcb0b69ea58458b1","msg":{"ts":1439388493,"subject":"New Password Request - My Namibia","email":"travelnamibie@gmail.com","tags":["password_reset"],"opens":[],"clicks":[],"state":"sent","smtp_events":[],"subaccount":null,"resends":[],"reject":null,"_id":"301ba728c2ad4cd7bcb0b69ea58458b1","sender":"no-reply@my.na","template":null},"ts":1439388493}]';

        $row = json_decode($o);
        var_dump($row);

        echo $row[0]->event;

        if (is_array($row[0]->msg->tags)) {

            echo 'wohoo';
            foreach ($row[0]->msg->tags as $trow) {

                if ($x2 == 0) {

                    if (substr($trow, 0, 9) == 'email_id_') {

                        echo 'Yup;';
                        $email_id = str_replace('email_id_', '', $trow);

                        $in['email_id'] = $email_id;
                        $in['status'] = $row[0]->event;
                        //$in['sends'] = $email_id;
                        //$in['unique_opens'] = $email_id;
                        $in['result'] = json_encode($row[0]);
                        //$in['email_id'] = $email_id;

                        $this->db->insert('emails_stats', $in);
                        $x2++;

                    }

                }

            }

        }


/*        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(50);
        $s = $this->db->get('email_events');

        if($s->result()){

            foreach($s->result() as $rr){

                    $o1 = $rr;
                    $o = $o1->mandrill_events;

                    $a = json_decode($o);

                    $a2 = json_decode($a->mandrill_events);

                    //var_dump($a2);
                    $x = 0;
                    foreach($a2 as $row) {

                        if ($x == 0) {

                            var_dump($row->msg);

                        }
                        $x2 = 0;
                        if (is_array($row->msg->tags)) {

                            foreach ($row->msg->tags as $trow) {

                                if ($x2 == 0) {

                                    if (substr($trow, 0, 9) == 'email_id_') {

                                        echo 'Yup;';
                                        $email_id = str_replace('email_id_', '', $trow);

                                        $in['email_id'] = $email_id;
                                        $in['status'] = $row->event;
                                        //$in['sends'] = $email_id;
                                        //$in['unique_opens'] = $email_id;
                                        $in['result'] = json_encode($row);
                                        //$in['email_id'] = $email_id;

                                        $this->db->insert('emails_stats', $in);
                                        $x2++;

                                    }

                                }

                            }

                        }



                        echo $row->event . ' ' . $row->msg->subject . ' Tags: - ' . $email_id . '< br />';
                        $x++;
                    }
            }


        }else{


        }*/



        //echo $x .' Records';

    }
	//+++++++++++++++++++++++++++
	//GET ACCCOUNT SETTINGS
	//++++++++++++++++++++++++++

	public function get_config()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('config');
		if($query->result()){
			
			$row = $query->row_array();
			return $row['components'];
			
		}else{
			
			return '';	
		}
		
	}
	
	 
	 //+++++++++++++++++++++++++++
	 //PRODUCTS
	 //++++++++++++++++++++++++++
	
	 public function products()
	 {
		  if($this->session->userdata('admin_id')){
		   
		   	$this->load->view('admin/products/products');
		   
		  }else{
		   
		   	$this->load->view('admin/login');
		   
		  } 
	 } 
	  //+++++++++++++++++++++++++++
	 //GET SUB CATEGORIES PRODUCT
	 //++++++++++++++++++++++++++
	
	 public function get_product_sub_cats($check, $tid, $id)
	 {
	   $this->admin_model->get_all_product_category_types($check, $tid, $id);
	 }                                             
	
	
	 //+++++++++++++++++++++++++++
	 //add new product
	 //++++++++++++++++++++++++++
	
	 public function add_product()
	 {
		  if($this->session->userdata('admin_id')){
		   
				$this->load->view('admin/products/add_product');
		   
		  }else{
		   
				 $this->load->view('admin/login');
		   
		  }
	  
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //update product
	 //++++++++++++++++++++++++++
	
	 public function update_product($product_id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $product = $this->admin_model->get_product($product_id);
			   $this->load->view('admin/products/update_product', $product);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	  
	  
	 }
	
	//+++++++++++++++++++++++++++
	//ADD PRODUCT DO
	//++++++++++++++++++++++++++	
	function add_product_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$type = $this->input->post('type', TRUE);
			$type_s = $this->input->post('type_s', TRUE);
			
			$url_link = $this->input->post('url_link', TRUE);
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');

			$input = trim($url_link, '/');
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}

		
			if($slug == ''){
				
				$slug = $this->clean_url_str($title, $replace=array(), $delimiter='-' , 'product', 'add');
			}else{
				
				$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'product', 'add');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
//							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'sku_code'=> $sku ,
								  'category'=> $type ,
								  'category_type'=> $type_s ,
								  'description'=> $body ,
								  'start_price'=> $start_price ,
								  'sale_price'=> $sale_price ,
								  'url_link'=> $url_link ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug,
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){

					$this->db->insert('products', $insertdata);
					$productid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_product-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Product added successfully');
					$data['basicmsg'] = 'Product has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_product/'.$productid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	
	 //+++++++++++++++++++++++++++
	//UPDATE PRODUCT
	//++++++++++++++++++++++++++	
	function update_product_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$special = $this->input->post('special', TRUE);
			$status = $this->input->post('status', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$type = $this->input->post('type', TRUE);
			$type_s = $this->input->post('type_s', TRUE);
			$manufacturer = $this->input->post('manufacturer', TRUE);
			$url_link = $this->input->post('url_link', TRUE);			
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('product_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			$bus_id = $this->session->userdata('bus_id');
	
			$input = trim($url_link, '/');
			
			if($special == 'Y') { $special = $special; } else { $special = 'N'; }
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'sku_code'=> $sku ,
								  'category'=> $type ,
								  'category_type'=> $type_s ,
								  'manufacturer'=> $manufacturer ,
								  'description'=> $body ,
								  'start_price'=> $start_price ,
								  'sale_price'=> $sale_price ,
								  'url_link'=> $url_link ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'listing_date'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug,
								  'sequence'=> $sequence,
								  'status'=> strtolower($status),
								  'special'=> $special,
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('product_id' , $id);
					$this->db->update('products', $insertdata);
					//success redirect	
					$data['product_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_product-'. $id);
					$data['basicmsg'] = 'Product has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//DELETE PRODUCT
	function delete_product($product_id){
      	
		if($this->session->userdata('admin_id')){
			
		$bus_id = $this->session->userdata('bus_id');
		
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $product_id);
			  $query = $this->db->where('type', 'product');
			  $query = $this->db->get('images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				
		
			  //delete from database
			  $query = $this->db->where('product_id', $product_id);
			  $this->db->delete('products');
			  
			  //delete from database
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type', 'product');
			  $query = $this->db->where('type_id', $product_id);
			  $this->db->delete('images');	
			  
			  
			  		  
/*				$query2 = $this->db->select('wishlist');
				$query2 = $this->db->where('bus_id', $bus_id);
				$query2 = $this->db->get('premier_members');	
				
				if($query2->result()){
					
					foreach($query2->result() as $row2){
					
						$wishlist = json_decode($row2->wishlist);
				 

						
						foreach(array_keys($wishlist) as $key) {
						   
						   if($wishlist[$key][0] == $product_id) {
							   unset($wishlist[$key]);
							   $wishlist = array_values($wishlist);
						   }
						}			
						
						$wishlist = array_values($wishlist);
						
						//print_r($wishlist);
						
						$new_items = json_encode($wishlist);
						
						$insertdata1 = array(
						  'wishlist'=> $new_items ,
						);
						
						$this->db->where('member_id', $row2->member_id);	
						$this->db->where('bus_id', $bus_id);					
						$this->db->update('premier_members',$insertdata1);	
						
					}
			   }*/
			    
			  
			  //LOG
			  $this->admin_model->system_log('delete_product-'.$product_id);
			  $this->session->set_flashdata('msg','Product deleted successfully');
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	
	//-----------------------------------//
	//NSA PUBLICATIONS	
	//-----------------------------------//
	

	//+++++++++++++++++++++++++++
	//NSA PUBS
	//++++++++++++++++++++++++++

	public function nsa_pubs()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('nsa_pub_model');
			$this->load->view('admin/nsa_pubs/pubs');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		


	//+++++++++++++++++++++++++++
	//NSA CATEGORIES
	//++++++++++++++++++++++++++

	public function nsa_categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('nsa_pub_model');
			$this->load->view('admin/nsa_pubs/categories');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//ADD NSA CATEGORY
	//++++++++++++++++++++++++++

	public function add_nsa_category()
	{
		$bus_id = $this->session->userdata('bus_id');	
			
		//INSERT INTO TOPICS
		$data['cat_name'] = $this->input->post('category');
		$data['bus_id'] = $bus_id;
		
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('nsa_categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('nsa_categories', $data);	
		}	
	}
	
	
	
	//+++++++++++++++++++++++++++
	//RELOAD NSA CATEGORIES ALL
	//++++++++++++++++++++++++++

	public function reload_nsa_categories_all()
	{
		$this->load->model('nsa_pub_model'); 
		$this->nsa_pub_model->get_all_categories();
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE NSA CATEGORY
	//++++++++++++++++++++++++++

	public function delete_nsa_category($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('nsa_categories');
		
	}
	
	//+++++++++++++++++++++++++++
	//add new NSA publication
	//++++++++++++++++++++++++++

	public function add_pub()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('nsa_pub_model'); 
			$this->load->view('admin/nsa_pubs/add_pub');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//update NSA publication
	//++++++++++++++++++++++++++

	public function update_pub($pub_id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('nsa_pub_model'); 
			
			$pub = $this->nsa_pub_model->get_pub($pub_id);
			$this->load->view('admin/nsa_pubs/update_pub', $pub);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD NSA PUBLICATION DO
	//++++++++++++++++++++++++++	
	function add_nsa_pub_do()
	{
			$title = $this->input->post('title', TRUE);
			$category = $this->input->post('category', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		 
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Publication title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
//					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						  'cat_id'=> $category,
						  'title'=> $title,
						  'slug'=> $slug,
						  'pub_doc'=> NULL,
						  'pub_data'=> NULL,						  
						  'sequence'=> $sequence,
						  'bus_id'=> $bus_id
				);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('nsa_pubs', $insertdata);
					$pubid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_publication-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Publication added successfully');
					$data['basicmsg'] = 'Publication has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_pub/'.$pubid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PUBLICATION
	//++++++++++++++++++++++++++	
	function update_nsa_pub_do()
	{
			$bus_id = $this->session->userdata('bus_id');
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$category = $this->input->post('category', TRUE);
			$pub_id = $this->input->post('pub_id', TRUE);
			$status = $this->input->post('status', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			$listing_date = $this->input->post('listing_date', TRUE);
		    
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications');
					
			}else{

				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');
				
			}
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Publication title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'cat_id'=> $category,
					  'title'=> $title,
					  'active'=> strtolower($status),
					  'slug'=> $slug,
					  'sequence'=> $sequence,
					  'listing_date'=> $listing_date,
					  'bus_id'=> $bus_id 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('pub_id' , $pub_id);
					$this->db->update('nsa_pubs', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_publication-'. $pub_id);
					$data['basicmsg'] = 'Publication has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}	
	
	
	
	
	//DELETE PUBLICATION
	function delete_nsa_pub($pub_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('pub_id', $pub_id);
			  $this->db->delete('nsa_pubs');
			  //LOG
			  $this->admin_model->system_log('delete_publication-'.$pub_id);
			  $this->session->set_flashdata('msg','Publication deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/nsa_pubs/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	
	
	
	
	//+++++++++++++++++++++++++++
	//update NSA publication sequence
	//++++++++++++++++++++++++++

	public function update_nsa_pub_sequence($chart_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('chart_id' , $chart_id);
		$this->db->update('nsa_pubs', $data);	
	}
	
	//+++++++++++++++++++++++++++
	//update NSA Cat sequence
	//++++++++++++++++++++++++++

	public function update_nsa_cat_sequence($cat_id , $sequence)
	{	
		$data['sequence'] = $sequence;
		$this->db->where('cat_id' , $cat_id);
		$this->db->update('nsa_categories', $data);	
	}				
	
	
	public function reload_area($pub_id , $data)
	{	

			$this->load->model('nsa_pub_model');
			$this->nsa_pub_model->get_pub_doc($pub_id,$data);
		
	}	




	//+++++++++++++++++++++++++++
	//Recipes
	//++++++++++++++++++++++++++

	public function recipes()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/recipes/recipes');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}

	//+++++++++++++++++++++++++++
	//add new recipe
	//++++++++++++++++++++++++++

	public function add_recipe()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/recipes/add_recipe');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//update recipe
	//++++++++++++++++++++++++++

	public function update_recipe($recipe_id)
	{
		if($this->session->userdata('admin_id')){
			
			$page = $this->admin_model->get_recipe($recipe_id);
			
			$this->load->view('admin/recipes/update_recipe', $page);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD RECIPE DO
	//++++++++++++++++++++++++++	
	function add_recipe_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$category = $this->input->post('category', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages');
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Recipe title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'title'=> $title,
					  'slug'=> $slug,
					  'cat_id'=> $category,
					  'metaT'=> $metaT,
					  'metaD'=> $metaD,
					  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('recipes', $insertdata);
					$recipeid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_recipe-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Recipe added successfully');
					$data['basicmsg'] = 'Recipe has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."admin/update_recipe/".$recipeid."/';
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	
		
	//+++++++++++++++++++++++++++
	//UPDATE RECIPE
	//++++++++++++++++++++++++++	
	function update_recipe_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);	
			$category = $this->input->post('category', TRUE);
			$status = $this->input->post('status', TRUE);

			$instructions = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('instructions', FALSE)));
			$description = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('description', FALSE)));
			$notes = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('notes', FALSE)));
			
			$cook = $this->input->post('cook', TRUE);
			$prep = $this->input->post('prep', TRUE);
			$serves = $this->input->post('serves', TRUE);
			
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('recipe_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Recipe title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						  'cat_id'=> $category,
						  'title'=> $title ,
						  'status'=> strtolower($status),
						  'instructions'=> $instructions ,
						  'description'=> $description ,
						  'notes'=> $notes ,
						  'prep'=> $prep ,
						  'cook'=> $cook ,
						  'serves'=> $serves ,
						  'metaD'=> $metaD,
						  'metaT'=> $metaT,
						  'slug'=> $slug ,  
						  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('recipe_id' , $id);
					$this->db->update('recipes', $insertdata);
					//success redirect	
					$data['recipe_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_recipe-'. $id);
					
					
					
					$data['basicmsg'] = 'Recipe has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	

	//+++++++++++++++++++++++++++
	//UPDATE RECIPE COPYRIGHT
	//++++++++++++++++++++++++++	
	function update_recipe_copyright()
	{
			$original_by = $this->input->post('original_by', TRUE);
			$photo_by = $this->input->post('photo_by', TRUE);	
			$id = $this->input->post('recipe_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			
			
				$insertdata = array(
						  'original_by'=> $original_by,
						  'photo_by'=> $photo_by
					);
			

				
					$this->db->where('recipe_id' , $id);
					$this->db->update('recipes', $insertdata);
					//success redirect	
					$data['recipe_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_recipe-'. $id);
					
					
					
					$data['basicmsg'] = 'Recipe Copyright has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

	}	
	
	
	
	//DELETE Recipe
	function delete_recipe($recipe_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('recipe_id', $recipe_id);
			  $this->db->delete('recipes');
			  
			  //delete ingredients
			  $test2 = $this->db->where('recipe_id', $recipe_id);
			  $this->db->delete('recipe_ingredients');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_recipe-'.$recipe_id);
			  $this->session->set_flashdata('msg','Recipe deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/recipes/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	//+++++++++++++++++++++++++++
	//RECIPE CATEGORIES
	//++++++++++++++++++++++++++

	public function recipe_categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/recipes/categories');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//ADD RECIPE CATEGORY
	//++++++++++++++++++++++++++

	public function add_recipe_category()
	{
		$bus_id = $this->session->userdata('bus_id');	
			
		//INSERT INTO TOPICS
		$data['title'] = $this->input->post('category');
		$data['bus_id'] = $bus_id;
		
		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('recipe_categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('recipe_categories', $data);	
		}

		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD RECIPE CATEGORIES ALL
	//++++++++++++++++++++++++++

	public function reload_recipe_categories_all()
	{ 
		$this->admin_model->get_recipe_categories();
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE RECIPE CATEGORY
	//++++++++++++++++++++++++++

	public function delete_recipe_category($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('recipe_categories');
		
	}	
	
	


	//+++++++++++++++++++++++++++
	//ADD INGREDIENT
	//++++++++++++++++++++++++++	
	function add_ingredient()
	{
			$ingredient = $this->input->post('ingredient', TRUE);
			$recipe_id = $this->input->post('recipe_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  

			
			//VALIDATE INPUT
			if($ingredient == ''){
				$val = FALSE;
				$error = 'Ingredient Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'ingredient'=> $ingredient,
					  'recipe_id'=> $recipe_id,
					  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('recipe_ingredients', $insertdata);
					$ingid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_ingredient-'.$ingredient);
					//success redirect	
					$this->session->set_flashdata('msg','Ingredient added successfully');
					$data['basicmsg'] = 'Ingredient has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD PRODUCT INGREDIENT
	//++++++++++++++++++++++++++	
	function add_product_ingredient()
	{
			$ingredient = $this->input->post('ingredient', TRUE);
			$product = $this->input->post('product', TRUE);
			$recipe_id = $this->input->post('recipe_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		     
		  
		    $query = $this->db->query("SELECT title FROM products WHERE product_id = '".$product."'", FALSE);
			
			$row = $query->row(); 
			
			$title = $row->title;
			$type = 'product';
			
			$ingredient = $ingredient.' '.$title;

			
			//VALIDATE INPUT
			if($ingredient == ''){
				$val = FALSE;
				$error = 'Ingredient Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'ingredient'=> $ingredient,
					  'type'=> $type,
					  'type_id'=> $product,
					  'recipe_id'=> $recipe_id,
					  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('recipe_ingredients', $insertdata);
					$ingid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_ingredient-'.$ingredient);
					//success redirect	
					$this->session->set_flashdata('msg','Ingredient added successfully');
					$data['basicmsg'] = 'Ingredient has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	
	
	 //+++++++++++++++++++++++++++
	//UPDATE INGREDIENT
	//++++++++++++++++++++++++++	
	function update_ingredient()
	{
			$ingredient = $this->input->post('ingredient', TRUE);
			$recipe_id = $this->input->post('recipe_id', TRUE);	
			$ingredient_id = $this->input->post('ingredient_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			
			
			//VALIDATE INPUT
			if($ingredient == ''){
				$val = FALSE;
				$error = 'Ingredient title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						  'ingredient'=> $ingredient
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('ingredient_id' , $ingredient_id);
					$this->db->update('recipe_ingredients', $insertdata);
					//success redirect	
					$data['ingredient_id'] = $ingredient_id;
					
					//LOG
					$this->admin_model->system_log('update_ingredient-'. $ingredient_id);
					
					
					
					$data['basicmsg'] = 'Ingredient has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}	
	
	
	
	

	//DELETE INGREDIENT
	function delete_ingredient($ingredient_id){
      	
		if($this->session->userdata('admin_id')){
			
			  //delete ingredients
			  $test2 = $this->db->where('ingredient_id', $ingredient_id);
			  $this->db->delete('recipe_ingredients');			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_ingredient-'.$ingredient_id);
			  $this->session->set_flashdata('msg','Ingredient successfully removed');
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	public function reload_ingredients($recipe_id)
	{
		$this->admin_model->get_all_ingredients($recipe_id);
		
	}
	
	public function update_ingredient_form($iid, $rid) {
			
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT ingredient FROM recipe_ingredients WHERE bus_id = '".$bus_id."' AND ingredient_id = '".$iid."'");
		  if($query->result()){
			  
			  $row = $query->row();
					  
				echo '
					<input type="hidden" name="ingredient_id"  value="'.$iid.'">
					<input type="hidden" name="recipe_id"  value="'.$rid.'">
					<input name="ingredient" id="upd-ingredient" type="text" value="'.$row->ingredient.'" style="display:block" class="span5">	
				';
				
		  }
		
	}



	public function import_product_csv() {

		if($this->session->userdata('admin_id')){

			$this->admin_model->import_product_csv();
			
		}else{
			
			$this->load->view('admin/login');
			
		}		
		
	}


	//+++++++++++++++++++++++++++
	//MANUFACTURERS
	//++++++++++++++++++++++++++

	public function manufacturers()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/products/manufacturers');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		
	//+++++++++++++++++++++++++++
	//ADD MANUFACTURER
	//++++++++++++++++++++++++++

	public function add_manufacturer()
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->add_manufacturer();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE MANUFACTURER
	//++++++++++++++++++++++++++

	public function delete_manufacturer($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->delete_manufacturer($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD MANUFACTURERS ALL
	//++++++++++++++++++++++++++

	public function reload_manufacturer_all()
	{
		$this->admin_model->get_all_manufacturers();
		
	}
	
	//+++++++++++++++++++++++++++
	//update Manufacturer sequence
	//++++++++++++++++++++++++++

	public function update_manufacturer_sequence($man_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('manufacturer_id' , $man_id);
			$this->db->update('product_manufacturer', $data);

		
	}	
	




	 //+++++++++++++++++++++++++++
	 //ADD PAGE PEOPLE DO
	 //+++++++++++++++++++++++++++
	 public function add_page_people()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->admin_model->add_page_people_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE PAGE PEOPLE DO
	//++++++++++++++++++++++++++
	function delete_page_people($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->admin_model->delete_page_people_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	
	//+++++++++++++++++++++++++++++++
	//UPDATE PAGE PEOPLE SEQUENCE
	//+++++++++++++++++++++++++++++++
	public function update_page_people_sequence($id, $page_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('page_id' , $page_id);
			$this->db->where('id' , $id);
			$this->db->update('page_people_int', $data);

	}
	
	//++++++++++++++++++++++++++++
	// RELOAD PAGE PEOPLE ALL
	//++++++++++++++++++++++++++++

	public function reload_page_people_all($id)
	{
		$this->admin_model->get_page_people($id);
		
	}		
		


	//+++++++++++++++++++++++++++
	//UNSUBSCRIBE
	//++++++++++++++++++++++++++
	public function unsubscribe($email)
	{	
		$email = rawurldecode($this->encrypt->decode($email,  $this->config->item('encryption_key')));
		$this->db->where('email', $email);
		$this->db->delete('subscribers');
		
		
	}
	 
	  
	//+++++++++++++++++++++++++++
	//ENCRYPRION FUNCTIONS
	//++++++++++++++++++++++++++
	
	public function encrypt($email, $pass)
	{
		$str = str_replace('_-_','@',$email);
//		$str = 'sme@my.na';
//		$pass = '123';
		echo $this->admin_model->hash_password($str,$pass);	
		
	}
	
	public function decrypt($str,$pass)
	{
		
		//echo $this->encrypt_model->hash_password($str,$pass);	
		
		$row = $this->admin_model->validate_password($str,$pass);
		if($this->admin_model->validate_password($str,$pass)){
			
			echo 'YES';
		
		}else{
			
			echo 'No';
			
		}
		
	}
	

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS NAME
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean; 
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $replace=array(), $delimiter='-' , $type, $action = 'update') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean); 
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		
		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$bus_id = $this->session->userdata('bus_id');
		
		$this->db->where('bus_id', $bus_id);
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);

		//IF UPDATING WE NEED TO TEST IF THERE ARE 2 ITEMS
		//including itself and the culprit
		if($action == 'update'){


			if($res->num_rows > 1){

				$clean = $clean .'-'.rand(0,99);
				return $clean;

			}else{

				return $clean;
			}

		//IF ADDING WE NEED TO TEST IF THERE IS 1 ITEM
		//with the current slug
		}else{

			if($res->result()){

				$clean = $clean .'-'.rand(0,99);
				return $clean;

			}else{

				return $clean;
			}

		}

		
		
	}
	
	
}



/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */
