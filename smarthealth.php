<?php

	include 'api/config/open_db.php';
	
	class smarthealth
	{
		function getSpeciality()
		{
			$str='"';
			$i=0;
			$query="select speciality from tbl_speciality 
					UNION 
					select distinct UPPER(speciality) from tbl_doctor";
			$q1=mysql_query($query);
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["speciality"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',str_replace(' ,',',',str_replace(', ',',',$str)))," ");
			$arr = explode(",",$str);
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
			return $str;
		}
		
		function getDoctorName()
		{
			$str = "";
			
			$q1=mysql_query("select doctor_id, doctor_name from tbl_doctor where isActive=1");
			while($r1=mysql_fetch_array($q1))
			{
				$str .= '<option value="'.$r1["doctor_id"].'">'.$r1["doctor_name"].'</option>';
			}
			
			return $str;
		}
		
		function getFacilityName()
		{
			$str = "";
			
			$q1=mysql_query("select facility_id, facility_name from tbl_facility where isActive=1");
			while($r1=mysql_fetch_array($q1))
			{
				$str .= '<option value="'.$r1["facility_id"].'">'.$r1["facility_name"].'</option>';
			}
			
			return $str;
		}
		
		function getLoginValid($login_id,$password)
		{
			//echo "select SGM_MEM_ID from user_login_credentials where (sgm_mem_id='".$login_id."' or email='".$login_id."') and password='".$password."'";
			//echo "select a.EMP_ID from user_login_credentials a, emp_master b where a.emp_id='".$login_id."' and a.password='".$password."' and a.emp_id=b.emp_id and b.active=1";
			//echo "<br>";
			//echo "select a.EMP_ID from user_login_credentials a, emp_master b where a.emp_id='".$login_id."' and a.password='".md5($password)."' and a.emp_id=b.emp_id and b.active=1";
			$q1=mysql_query("select a.EMP_ID from user_login_credentials a, emp_master b where a.emp_id='".$login_id."' and a.password='".md5($password)."' 
							and a.emp_id=b.emp_id and b.active=1");
			$r1=mysql_fetch_array($q1);
			//echo md5($password);
			return $r1[0];
		}
		
		function getFacility()
		{
			$i=0;
			$str="";
			$query = "SELECT  facility_name, facility_address, facility_lat, facility_lng, facility_phone, pic_name 
					FROM  tbl_facility where isActive=1";
			$exec = mysql_query($query);
			while($res=mysql_fetch_array($exec))
			{
				$i++;
				$str .= '<div class="col-md-4 col-sm-6">
						<div class="card-container manual-flip">
							<div class="card">
								<div class="front">
									<div class="cover">
										<img src="images/facility_bg.jpg"/>
									</div>
									<div class="user">
										<img class="img-circle" src="profile_pic/'.$res["pic_name"].'"/>
									</div>
									<div class="content">
										<div class="main">
											<h3 class="name">'.$res["facility_name"].'</h3>
											<p class="profession"></p>
											<p class="text-center">'.$res["facility_address"].'<br>Ph: '.$res["facility_phone"].'</p>
										</div>
										<div class="footer">
											<button class="btn btn-simple" onclick="rotateCard(this);initMap(\'map'.$i.'\','.$res["facility_lat"].','.$res["facility_lng"].')">
												<i class="fa fa-mail-forward"></i> Details
											</button>
										</div>
									</div>
								</div> <!-- end front panel -->
								<div class="back">
									<div class="header" style="height: 10%">
										<h5 class="motto">Map Location</h5>
									</div>
									<div class="content" style="height: 73%">
										<div class="main" id="map'.$i.'" style="width: 100%; height: 100%;">
											<h4 class="text-center">Contact</h4>
											<p class="text-center">Map will go here</p>
											
										</div>
									</div>
									<div class="footer">
										<button class="btn btn-simple" rel="tooltip" title="Flip Card" onclick="rotateCard(this)">
											<i class="fa fa-reply"></i> Back
										</button>
										<div class="social-links text-center">
											<a href="http://localhost/smarthealth" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
											<a href="http://localhost/smarthealth" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
											<a href="http://localhost/smarthealth" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
										</div>
									</div>
								</div> <!-- end back panel -->
							</div> <!-- end card -->
						</div> <!-- end card-container -->
					</div> <!-- end col sm 3 -->';
			}
			return $str;
		}
		
		function getDoctor()
		{
			$str="";
			$query = "SELECT  doctor_id ,  doctor_name ,  doctor_address ,  doctor_email ,  doctor_phone ,  doctor_regno ,  speciality ,  doctor_exp ,  pic_name 
					FROM  tbl_doctor where isActive=1";
			$exec = mysql_query($query);
			while($res=mysql_fetch_array($exec))
			{
				$str .= '<div class="col-md-4 col-sm-6">
						<div class="card-container manual-flip">
							<div class="card">
								<div class="front">
									<div class="cover">
										<img src="images/doctor_bg.jpg"/>
									</div>
									<div class="user">
										<img class="img-circle" src="profile_pic/'.$res["pic_name"].'"/>
									</div>
									<div class="content">
										<div class="main">
											<h3 class="name">'.$res["doctor_name"].'</h3>
											<p class="profession">'.$res["speciality"].'</p>
											<p class="text-center">'.$res["doctor_exp"].' yrs of experience</p>
										</div>
										<div class="footer">
											<button class="btn btn-simple" onclick="rotateCard(this)">
												<i class="fa fa-mail-forward"></i> Details
											</button>
										</div>
									</div>
								</div> <!-- end front panel -->
								<div class="back">
									<div class="header">
										<h5 class="motto">'.$res["doctor_regno"].'</h5>
									</div>
									<div class="content">
										<div class="main">
											<h4 class="text-center">Contact</h4>
											<p class="text-center">'.$res["doctor_address"].'<br>'.$res["doctor_email"].'<br>Ph: '.$res["doctor_phone"].'</p>
											
											<div class="stats-container">
												<div class="stats">
													<h4>235</h4>
													<p>
														Followers
													</p>
												</div>
												<div class="stats">
													<h4>114</h4>
													<p>
														Following
													</p>
												</div>
												<div class="stats">
													<h4>35</h4>
													<p>
														Projects
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="footer">
										<button class="btn btn-simple" rel="tooltip" title="Flip Card" onclick="rotateCard(this)">
											<i class="fa fa-reply"></i> Back
										</button>
										<div class="social-links text-center">
											<a href="http://localhost/smarthealth" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
											<a href="http://localhost/smarthealth" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
											<a href="http://localhost/smarthealth" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
										</div>
									</div>
								</div> <!-- end back panel -->
							</div> <!-- end card -->
						</div> <!-- end card-container -->
					</div> <!-- end col sm 3 -->';
			}
			return $str;
		}
		
		function getBookList($start)
		{
			$str='<div class="row">';
			$j=0;
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description as full_desc, substr(a.description,1,500) as description, a.cover, a.added 
							from tbl_book a 
							left join (select book_id, count(*) cnt from tbl_issue group by book_id) b 
							on a.ISBN=b.book_id 
							order by b.cnt desc 
							limit ".$start.", 9");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				//print_r($arr);
				$str .= '<div class="col-sm-4">
			<div class="card" style="width: 15rem; height: 70rem;">
				<img class="card-img-top" src="book_cover/'.$r1["cover"].'" width="100%" alt="" class="alignleft border" />
				<div class="card-header">
				<h2 class="card-title"><a href="book.php?ISBN='.$r1["ISBN"].'"><font>'.$r1["name"].'</font></a></h2>
				<p class="meta">by ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= ' since '.$date->format('d M Y').'</p>
				</div>
				<div class="entry">
					<p class="card-text">'.$r1["description"];
				if(strlen($r1["full_desc"])>200)
					$str .= '<a href="book.php?ISBN='.$r1["ISBN"].'" class="btn btn-primary"><font>.. read more</font></a>';
				$str .= '</p>';
//					<p class="clearfix">&nbsp;</p>
				$str .= '</div>
				</div>
			</div>
			';
				$j++;
				if($j%3==0)
					$str .= "</div>
				<div class='row'>";
			}
			$str .= '</div>';
			return $str;
		}
		function getEBookList($start)
		{
			$str='<div class="row">';
			$j=0;
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description as full_desc, substr(a.description,1,500) as description, a.cover, a.added 
							from tbl_ebook a 
							limit ".$start.", 9");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				//print_r($arr);
				$str .= '<div class="col-sm-4">
			<div class="card" style="width: 15rem; height: 70rem;">
				<img class="card-img-top" src="book_cover/'.$r1["cover"].'" width="100%" alt="" class="alignleft border" />
				<div class="card-header">
				<h2 class="card-title"><a href="ebook.php?ISBN='.$r1["ISBN"].'"><font>'.$r1["name"].'</font></a></h2>
				<p class="meta">by ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= ' since '.$date->format('d M Y').'</p>
				</div>
				<div class="entry">
					<p class="card-text">'.$r1["description"];
				if(strlen($r1["full_desc"])>200)
					$str .= '<a href="book.php?ISBN='.$r1["ISBN"].'" class="btn btn-primary"><font>.. read more</font></a>';
				$str .= '</p>';
//					<p class="clearfix">&nbsp;</p>
				$str .= '</div>
				</div>
			</div>
			';
				$j++;
				if($j%3==0)
					$str .= "</div>
				<div class='row'>";
			}
			$str .= '</div>';
			return $str;
		}
		function getIssueList($start)
		{
			$str='<div class="row">';
			$j=0;
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description as full_desc, substr(a.description,1,500) as description, a.cover, a.added 
							from tbl_book a ,
							(select book_id, count(*) cnt from tbl_issue where user_id='".$_SESSION["user_id"]."' group by book_id) b 
							where a.ISBN=b.book_id 
							order by b.cnt desc 
							limit ".$start.", 9");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				//print_r($arr);
				$str .= '<div class="col-sm-4">
			<div class="card" style="width: 15rem; height: 70rem;">
				<img class="card-img-top" src="book_cover/'.$r1["cover"].'" width="100%" alt="" class="alignleft border" />
				<div class="card-header">
				<h2 class="card-title"><a href="book.php?ISBN='.$r1["ISBN"].'"><font>'.$r1["name"].'</font></a></h2>
				<p class="meta">by ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= ' since '.$date->format('d M Y').'</p>
				</div>
				<div class="entry">
					<p class="card-text">'.$r1["description"];
				if(strlen($r1["full_desc"])>200)
					$str .= '<a href="book.php?ISBN='.$r1["ISBN"].'" class="btn btn-primary"><font>.. read more</font></a>';
				$str .= '</p>';
//					<p class="clearfix">&nbsp;</p>
				$str .= '</div>
				</div>
			</div>
			';
				$j++;
				if($j%3==0)
					$str .= "</div>
				<div class='row'>";
			}
			$str .= '</div>';
			return $str;
		}
		function getBookByISBN($ISBN)
		{
			$str='<div class="post row" style="padding-bottom:20px;">';
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description, a.cover, a.added 
							from tbl_book a 
							where a.ISBN='".$ISBN."'");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				$str .= '
			<div class="col-sm-3">
				<img src="book_cover/'.$r1["cover"].'" width="286" height="286" alt="" class="alignleft border" />
			</div>
				<div class="col-sm-9">
					<p><h2 class="title"><a href="book.php?ISBN='.$r1["ISBN"].'"><font color=white>'.$r1["name"].'</font></a></h2>
					<p><b>Author:</b> ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= '</p>
					<p><b>ISBN:</b> <font color="#A5C35C">'.$ISBN.'</font></p>
					<p><b>Added to library:</b> '.$date->format('d M Y').'</p>
					<p><b>Synopsis:</b> '.str_replace("\n","<br>",$r1["description"]);
				$str .= '</p></p>';
				if(isset($_SESSION["user_id"]))
				{
					$any_issue=$this->getAnyIssue($ISBN);
					if($any_issue==1)
						$str .= "<form method=post action='review_book.php'>
						<input type=hidden name='ISBN' value='".$ISBN."'>
						<div class='input-group'>
							<textarea id='review' name='review' class='form-control' placeholder='Write your review' onchange='javascript: submit_review1();'></textarea>
							<span class='input-group-btn'><input type=submit class='button' value='Review' style='background-color: #ff8040;'></button></span>
						</div>
						</form>
						";
//					else
//					{
						$issued_user=$this->getIssueStatus($ISBN);
						$eligible_user=$this->getEligibleUser($ISBN);
						/*if($this->getRequisitionByUser($ISBN,$_SESSION["user_id"])!="")
							echo "Requisition by User: ".$this->getRequisitionByUser($ISBN,$_SESSION["user_id"]);*/
						if($this->getRequisitionByUser($ISBN,$_SESSION["user_id"])!="" && $eligible_user!=$_SESSION["user_id"])
							$str .= "<label class='button' style='background-color: #008CBA; disabled'>Already joined the Queue</label>";
						else if($issued_user==$_SESSION["user_id"])
							$str .= "<form method=post action='return_book.php'><input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=submit class='button' value='Return' style='background-color: #f44336;'>
							</form>";
						else if($issued_user!="" && $eligible_user!=$_SESSION["user_id"])
							$str .= "<form method=post action='submit_request.php'><input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=submit class='button' value='Join the Queue' style='background-color: #008CBA;'>
							</form>";
						else if($issued_user!="" && $eligible_user==$_SESSION["user_id"])
							$str .= "<form method=post action='send_reminder.php'>
							<input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=hidden name='issued_user' value='".$issued_user."'>
							<input type=submit class='button' value='Send Reminder' style='background-color: #ff0000;'>
							</form>";
						else if($eligible_user==$_SESSION["user_id"])
							$str .= "<form method=post action='issue_book.php'><input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=submit class='button' value='Issue' style='background-color: #008000;'>
							</form>";
						else if($eligible_user=="")
							$str .= "<form method=post action='submit_request.php'><input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=submit class='button' value='Request' style='background-color: #4CAF50;'>
							</form>";
						else if($eligible_user!="")
							$str .= "<form method=post action='submit_request.php'><input type=hidden name='ISBN' value='".$ISBN."'>
							<input type=submit class='button' value='Join the Queue' style='background-color: #008CBA;'>
							</form>";
//					}
				}
				else
					$str .= "<a href='login.php'>
					<input type=submit class='button' value='Login' style='background-color: #8080c0;'>
					</a>";
				$str .= '
				</div>
			</div>
				';
			}
			return $str;
		}
		function getBookByAuthor($author)
		{
			$str='<h4>Books>Author>'.$author.'</h4>
			<div class="post row">';
			$j=0;
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description as full_desc, substr(a.description,1,500) as description, a.cover, a.added 
							from (select * from tbl_book where author like '%".$author."%') a 
							left join (select book_id, count(*) cnt from tbl_issue group by book_id) b 
							on a.ISBN=b.book_id 
							order by b.cnt desc");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				//print_r($arr);
				$str .= '<div class="col-sm-4">
			<div class="card" style="width: 15rem; height: 70rem;">
				<img class="card-img-top" src="book_cover/'.$r1["cover"].'" width="100%" alt="" class="alignleft border" />
				<div class="card-header">
				<h2 class="card-title"><a href="book.php?ISBN='.$r1["ISBN"].'"><font>'.$r1["name"].'</font></a></h2>
				<p class="meta">by ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= ' since '.$date->format('d M Y').'</p>
				</div>
				<div class="entry">
					<p class="card-text">'.$r1["description"];
				if(strlen($r1["full_desc"])>200)
					$str .= '<a href="book.php?ISBN='.$r1["ISBN"].'" class="btn btn-primary"><font>.. read more</font></a>';
				$str .= '</p>';
//					<p class="clearfix">&nbsp;</p>
				$str .= '</div>
				</div>
			</div>
			';
				$j++;
				if($j%3==0)
					$str .= "</div>
				<div class='row'>";
			}
			$str .= '</div>';
			return $str;
		}
		function getIssueStatus($ISBN)
		{
			$q1=mysql_query("select user_id from tbl_issue where book_id='".$ISBN."' and issue_flag=0");
			$r1=mysql_fetch_array($q1);
			return $r1["user_id"];
		}
		function getAnyIssue($ISBN)
		{
			$q1=mysql_query("select issue_flag from tbl_issue where book_id='".$ISBN."' and user_id='".$_SESSION["user_id"]."' order by issue_date desc limit 0,1");
			$r1=mysql_fetch_array($q1);
			return $r1["issue_flag"];
		}
		function getEligibleUser($ISBN)
		{
			$q1=mysql_query("select user_id from tbl_requisition where book_id='".$ISBN."' limit 0,1");
			$r1=mysql_fetch_array($q1);
			return $r1["user_id"];
		}
		function getIssueByISBN($ISBN)
		{
			$str='
			<div class="col-sm-6">
				<h2 class="title">Issue List</h2>
				<div class="entry">
				';
			$query = "select c.emp_name, b.issue_date 
					from tbl_issue b, emp_master c 
					where b.user_id=c.emp_id 
					and b.book_id='".$ISBN."' ";
			$query .= "	and c.active=1 
					order by b.issue_date asc 
					limit 0,5";
			$q1=mysql_query($query);
			if(mysql_num_rows($q1)>0)
			{
				$str .= '
				<table style="border-collapse: collapse;">
					<tr bgcolor=white>
						<td style="padding-left:15px; padding-right:15px;">#</td>
						<td style="padding-left:15px; padding-right:15px;">Issuer</td>
						<td style="padding-left:15px; padding-right:15px;">Issue Date</td>
					</tr>';
				$i=1;
				while($r1=mysql_fetch_array($q1))
				{
					$date = new DateTime($r1["issue_date"]);
					$str .= '
						<tr style="color:#000;">
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px; text-align:right;">'.$i.'</td>
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px;">'.$r1["emp_name"].'</td>
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px;">'.$date->format('d M Y').'</td>
						' ;
					$str .= '</tr>
					';
					$i++;
				}
				$str .= '</table>';
			}
			else
				$str .= "<font color=black>The list is empty. Request now to grab it.</font>";
			$str .= '
				</div>
			</div>
			';
			return $str;
		}
		function getRequisitionByISBN($ISBN)
		{
			$str='
			<div class="col-sm-6">
				<h2 class="title">Waiting List</h2>
				<div class="entry">
				';
			$query = "select c.emp_name, b.requisition_date 
					from tbl_requisition b, emp_master c 
					where b.user_id=c.emp_id 
					and b.book_id='".$ISBN."' ";
			$query .= "	and c.active=1 
					order by b.requisition_date asc 
					limit 0,5";
			$q1=mysql_query($query);
			if(mysql_num_rows($q1)>0)
			{
				$str .= '
				<table style="border-collapse: collapse;">
					<tr bgcolor=white>
						<td style="padding-left:15px; padding-right:15px;">#</td>
						<td style="padding-left:15px; padding-right:15px;">Requestor</td>
						<td style="padding-left:15px; padding-right:15px;">Request Date</td>
					</tr>';
				$i=1;
				while($r1=mysql_fetch_array($q1))
				{
					$date = new DateTime($r1["requisition_date"]);
					$str .= '
						<tr style="color:#000;">
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px; text-align:right;">'.$i.'</td>
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px;">'.$r1["emp_name"].'</td>
							<td style="border: 1px solid black; padding-left:15px; padding-right:15px;">'.$date->format('d M Y g:i A').'</td>
						' ;
					$str .= '</tr>
					';
					$i++;
				}
				$str .= '</table>';
			}
			else
				$str .= "<font color=black>The list is empty. Request now to grab it.</font>";
			$str .= '
				</div>
			</div>
			';
			return $str;
		}
		function getRequisitionByUser($ISBN,$user)
		{
			$str='';
			$query = "select c.emp_name, b.requisition_date 
					from tbl_requisition b, emp_master c 
					where b.user_id=c.emp_id 
					and b.book_id='".$ISBN."' 
					and b.user_id='".$user."'";
			$query .= "	and c.active=1";
			$q1=mysql_query($query);
			if(mysql_num_rows($q1)>0)
			{
				$r1=mysql_fetch_array($q1);
				$str = $r1["emp_name"];
			}
			else
				$str = "";
			return $str;
		}
		function getReviewByISBN($ISBN)
		{
			$str='';
			$i=0;
			$query = "select c.emp_name, c.pic_name, b.review, b.review_date 
					from tbl_review b, emp_master c 
					where b.user_id=c.emp_id 
					and b.book_id='".$ISBN."' ";
			$query .= "	and c.active=1 
					order by b.review_date desc 
					limit 0,5";
			$q1=mysql_query($query);
			if(mysql_num_rows($q1)>0)
			{
				while($r1=mysql_fetch_array($q1))
				{
					if($i%2==0)
						$str .= '<div class="row" style="padding-bottom:20px; background-color: lightblue;">';
					else
						$str .= '<div class="row" style="padding-bottom:20px;">';
					$date = new DateTime($r1["review_date"]);
					$str .= '
							<div class="col-sm-2"><img src="upload/'.$r1["pic_name"].'" style="border-radius: 50%;width:80px;"></div>
							<div class="col-sm-2">'.$r1["emp_name"].'<br><i>on '.$date->format('d M Y').'</i></div>
							<div class="col-sm-8">'.$r1["review"].'</div>
						' ;
					$str .= '</div>';
					$i++;
				}
				$str .= '';
			}
			else
				$str .= "<font color=black>No reviews yet. Be the first one to review.</font>";
			$str .= '';
			return $str;
		}
		function getNotification($user_id)
		{
			$str='';
			$i=0;
			$query = "select b.emp_name requestor, c.emp_name requestee, d.name book_name, a.reminder_type, a.reminder_date 
					from tbl_reminder a, 
					(select emp_id, emp_name from emp_master where active=1) b, 
					(select emp_id, emp_name from emp_master where active=1) c, 
					(select ISBN, name from tbl_book) d 
					where a.requestor_id=b.emp_id 
					and a.requestee_id=c.emp_id 
					and a.book_id=d.ISBN 
					and a.requestee_id='".$user_id."' 
					group by a.requestor_id, a.requestee_id, a.reminder_type, SUBSTRING(a.reminder_date, 1, 10) 
					order by a.reminder_date desc";
			$q1=mysql_query($query);
			if(mysql_num_rows($q1)>0)
			{
				while($r1=mysql_fetch_array($q1))
				{
					if($i%2==0)
						$str .= '<div style="padding-top:20px; padding-bottom:20px; background-color: lightblue;">';
					else
						$str .= '<div style="padding-top:20px; padding-bottom:20px;">';
					$date = new DateTime($r1["reminder_date"]);
					if($r1["reminder_type"]=="Request")
						$str .= '
							<div style="float:left; padding-left:10px; padding-right:10px;"><img src="images/request.png" style="border-radius: 50%;width:40px;"></div>
							<div>Dear '.$r1["requestee"].', this to inform that '.$r1["requestor"].' has sent you a reminder to return your book <b>'.$r1["book_name"].'</b>, in case you have already finished reading it.<br><i>Request sent on '.$date->format('d M Y').'</i></div>
						' ;
					else if($r1["reminder_type"]=="Issue")
						$str .= '
							<div style="float:left; padding-left:10px; padding-right:10px;"><img src="images/notification.png" style="border-radius: 50%;width:40px;"></div>
							<div>Dear '.$r1["requestee"].', this to inform that your requested book <b>'.$r1["book_name"].'</b> has been returned. In case you have not planned otherwise, issue it at the earliest.<br><i>Request sent on '.$date->format('d M Y').'</i></div>
						' ;
					else if($r1["reminder_type"]=="Return")
						$str .= '
							<div style="float:left; padding-left:10px; padding-right:10px;"><img src="images/reminder.png" style="border-radius: 50%;width:40px;"></div>
							<div>Dear '.$r1["requestee"].', this to inform that your book <b>'.$r1["book_name"].'</b> is scheduled to be returned soon. Please return on time.<br><i>Request sent on '.$date->format('d M Y').'</i></div>
						' ;
					$str .= '</div>';
					$i++;
				}
				$str .= '';
			}
			else
				$str .= "<font color=black>No notification.</font>";
			$str .= '';
			return $str;
		}
		function getNotificationCount($user_id)
		{
			$query = "select b.emp_name requestor, c.emp_name requestee, d.name book_name, a.reminder_type, a.reminder_date 
					from tbl_reminder a, 
					(select emp_id, emp_name from emp_master where active=1) b, 
					(select emp_id, emp_name from emp_master where active=1) c, 
					(select ISBN, name from tbl_book) d 
					where a.requestor_id=b.emp_id 
					and a.requestee_id=c.emp_id 
					and a.book_id=d.ISBN 
					and a.requestee_id='".$user_id."' 
					order by a.reminder_date desc";
			$q1=mysql_query($query);
			$count=mysql_num_rows($q1);
			return $count;
		}
		function getAllBookName()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct name from tbl_book");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["name"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',$str)," ");
/*			$arr = explode(",",str_replace(',','","',$str));
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
*/			return $str;
		}
		function getAllAuthor()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct author from tbl_book");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["author"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',str_replace(' ,',',',str_replace(', ',',',$str)))," ");
			$arr = explode(",",$str);
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
			return $str;
		}
		function getAllGenre()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct genre from tbl_book");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["genre"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',str_replace(' ,',',',str_replace(', ',',',$str)))," ");
			$arr = explode(",",$str);
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
			return $str;
		}
		function getAllEBookName()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct name from tbl_ebook");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["name"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',$str)," ");
/*			$arr = explode(",",str_replace(',','","',$str));
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
*/			return $str;
		}
		function getAllEAuthor()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct author from tbl_ebook");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["author"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',str_replace(' ,',',',str_replace(', ',',',$str)))," ");
			$arr = explode(",",$str);
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
			return $str;
		}
		function getAllEGenre()
		{
			$str='"';
			$i=0;
			$q1=mysql_query("select distinct genre from tbl_ebook");
			while($r1=mysql_fetch_array($q1))
			{
				if($i>0)
					$str .= ",";
				$str .= $r1["genre"];
				$i++;
			}
			$str .= '"';
			$str = strtoupper($str);
			$str = trim(str_replace(',','","',str_replace(' ,',',',str_replace(', ',',',$str)))," ");
			$arr = explode(",",$str);
			//print_r($arr);
			$arr_unq = array_unique($arr);
			//print_r($arr_unq);
			$str = implode(",",$arr_unq);
			return $str;
		}
		
		function RandomString()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = '';
			for ($i = 0; $i < 30; $i++) {
				$randstring .= $characters[rand(0, strlen($characters)-1)];
			}
			return $randstring;
		}
		/* gets the data from a URL */
		function get_data($url)
		{
			//echo $url;
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}
		function getEbookByISBN($ISBN)
		{
			$ebook_cover="'ebook_cover'";
			$str='<div class="post row" style="padding-bottom:20px;">';
			$q1=mysql_query("select a.ISBN, a.name, a.author, a.description, a.cover, a.added 
							from tbl_ebook a 
							where a.ISBN='".$ISBN."'");
			while($r1=mysql_fetch_array($q1))
			{
				$date = new DateTime($r1["added"]);
				$arr = explode(",",$r1["author"]);
				$str .= '
			<div class="col-sm-3">
				<img id="cover_photo" src="book_cover/'.$r1["cover"].'" style="max-width:300px; max-height:300px;" alt="" class="alignleft border" />';
			if($_SESSION["user_id"]=="admin")
				$str .= '<form method=post action="update_ebook.php" enctype="multipart/form-data">
							<div class="input-group" style="width:200px;">
								<input class="form-control" type=file id="ebook_cover" name="ebook_cover" accept="image/*" placeholder="E-book Cover" style="display:none; width:200px;" onchange="javascript:loadFile(event); show_file('.$ebook_cover.');">
								<label class="form-control" for="ebook_cover" id="ebook_cover_name" style="width:200px; display:block;">Select E-book cover</label>
							</div>
							<input type=hidden name="ISBN" value="'.$r1["ISBN"].'">
							<input type=submit class="button" value="Save" style="background-color: #8080c0;">
						</form>';
			$str .= '</div>
				<div class="col-sm-9">
					<p><h2 class="title"><a href="ebook.php?ISBN='.$r1["ISBN"].'"><font color=green>'.$r1["name"].'</font></a></h2>
					<p><b>Author:</b> ';
				for($i=0;$i<sizeof($arr);$i++)
				{
					if($i>0)
						$str .= ", ";
					$str .= '<a href="book_by_author.php?author='.trim($arr[$i]," ").'">'.trim($arr[$i]," ").'</a>';
				}
				$str .= '</p>
					<p><b>ISBN:</b> <font color="#A5C35C">'.$ISBN.'</font></p>
					<p><b>Added to library:</b> '.$date->format('d M Y').'</p>
					<p><b>Synopsis:</b> '.str_replace("\n","<br>",$r1["description"]);
				$str .= '</p></p>';
				if(isset($_SESSION["user_id"]))
				{
					$str .= "<form name='f1' method=post action='view.php'>
						<input type=hidden name='ISBN' value='".$ISBN."'>
						<div class='input-group'>
							<span class='input-group-btn'><input type=submit class='button' value='View' style='background-color: #ff8040;'></button></span>
						</div>
						</form>
						";
				}
				else
					$str .= "<a href='login.php'>
					<input type=submit class='button' value='Login' style='background-color: #8080c0;'>
					</a>";
				$str .= '
				</div>
			</div>
				';
			}
			return $str;
		}

/*		function convert_number_to_words($number)
		{
			$hyphen      = '-';
			$conjunction = ' and ';
			$separator   = ', ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'fourty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion'
			);

			if (!is_numeric($number)) {
				return false;
			}

			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
					'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
				);
				return false;
			}

			if ($number < 0) {
				return $negative . $this->convert_number_to_words(abs($number));
			}

			$string = $fraction = null;

			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}

			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . $this->convert_number_to_words($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= $this->convert_number_to_words($remainder);
					}
					break;
			}

			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}

			return $string;
		}
		
		function NumToWordsSmall($num)
		{
			$str="";
			//$str=$str.$num;
			$dictionary  = array(
				0                   => '',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20					=> 'twenty',
				30					=> 'thirty',
				40                  => 'fourty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety'
			);
			$len=strlen($num);
			if($len==2)
			{
				//$str=$str."Length>1<br>";
				if($num=="00")
				{
					$str=$str;
				}
				else if(substr($num,0,1)!="1")
				{
					$str=$str.ucfirst($dictionary[substr($num,0,1)."0"]);
					$len=1;
					$num=substr($num,1,1);
				}
				else
					$str=$str." ".ucfirst($dictionary[$num]);
			}
			if($len==1 && $num!="0")
			{
				//$str=$str."Length=1<br>";
				$str=$str." ".ucfirst($dictionary[$num]);
			}
			//$str.="Mamoni";
			return ucfirst($str);
		}

		function NumToWords($num)
		{
			$str="Rupees ";
			//$str=$str.$num;
			$dictionary  = array(
				0                   => '',
				00                   => '',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20					=> 'twenty',
				30					=> 'thirty',
				40                  => 'fourty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety'
			);
			$len=strlen($num);
			if($len>7)
			{
				//echo substr($num,0,$len-7);
				$str=$str.$this->NumToWordsSmall(substr($num,0,$len-7))." Crore ";
				$num=substr($num,$len-7,7);
				$len=7;
			}
			if($len>5)
			{
				//echo substr($num,0,$len-5);
				$str=$str.$this->NumToWordsSmall(substr($num,0,$len-5))." Lakh ";
				$num=substr($num,$len-5,5);
				$len=5;
			}
			if($len>3)
			{
				//echo substr($num,0,$len-3);
				$str=$str.$this->NumToWordsSmall(substr($num,0,$len-3))." Thousand ";
				$num=substr($num,$len-3,3);
				$len=3;
			}
			if($len>2)
			{
				$str=$str.ucfirst($dictionary[substr($num,0,1)])." Hundred ";
				$num=substr($num,1,2);
				$len=2;
			}
			if($len==2)
			{
				//$str=$str."Length>1 ".$num."<br>";
				if($num=="00")
				{
					$str=$str;
				}
				else if(substr($num,0,1)!="1")
				{
					if(substr($num,0,1)!="0")
						$str=$str.ucfirst($dictionary[substr($num,0,1)."0"]);
					$num=substr($num,1,1);
					$len=1;
				}
				else
					$str=$str." ".ucfirst($dictionary[$num]);
			}
			if($len==1 && $num!="0")
			{
				//$str=$str."Length=1<br>";
				$str=$str." ".ucfirst($dictionary[$num]);
			}
//			$str=strtoupper($str." Only");
			$str=$str." Only";
			return $str;
		}
		
		function getEmpSalSummary()
		{
			$i=0;
			$total=0;
			$str="";
			$str.="<table border=0 cellpadding='10' width=100%>
					<tr bgcolor=grey>
						<td rowspan=2 align=center><font size=2>Employee Name</td>
						<td colspan=9 align=center><font size=2>Earnings</td>
						<!--<td colspan=5 align=center><font size=2>Reimbursements</td>-->
						<td colspan=6 align=center><font size=2>Deductions</td>
						<td rowspan=2 align=center><font size=2>Net Salary</td>
					</tr>
					<tr bgcolor=grey>
						<td align=center><font size=1>Basic</td>
						<td align=center><font size=1>HRA</td>
						<td align=center><font size=1>Conveyance</td>
						<td align=center><font size=1>Spcl. Allowance</td>
						<td align=center><font size=1>Employer Contribution to PF</td>
						<td align=center><font size=1>Employer Contribution to ESI</td>
						<td align=center><font size=1>Bonus</td>
						<td align=center><font size=1>Arrear Salary</td>
						<td align=center><font size=1>Other Income</td>
						<!--<td align=center><font size=1>Medical Allowance</td>
						<td align=center><font size=1>LTA</td>
						<td align=center><font size=1>Telephone</td>
						<td align=center><font size=1>Internet</td>
						<td align=center><font size=1>Medical Insurance</td>-->
						<td align=center><font size=1>EPF Contribution</td>
						<td align=center><font size=1>ESI Contribution</td>
						<td align=center><font size=1>Prof. Tax</td>
						<td align=center><font size=1>Income Tax</td>
						<td align=center><font size=1>Advances</td>
						<td align=center><font size=1>Other Deductions</td>
					</tr>";
			$query="SELECT B.emp_name, A.* from (SELECT `emp_id`, `basic_pay`, `house_rent_allowance`, `conveyance_allowance`, `spcl_allowance`, `empr_pf`, `empr_esi`, `bonus`, `arrear`, `other_income`, `med_allw`, `lta`, `tel_reim`, `internet_reim`, `med_ins`, `epf_contribution`, `esi_contr`, `profession_tax`, `income_tax`, `advances`, `other_deduction` FROM `emp_sal_dtl` 
					WHERE 
					emp_id in (select distinct emp_id from emp_master where active=1)
					and active=1) A, emp_master B 
					where A.emp_id=B.emp_id 
					and B.active=1";
			$query.=" order by B.emp_name";
			//echo $query;
			$q1=mysql_query($query);
			while($r1=mysql_fetch_array($q1))
			{
				$basic_pay=round($r1["basic_pay"]/12,0);
				$house_rent_allowance=round($r1["house_rent_allowance"]/12,0);
				$conveyance_allowance=round($r1["conveyance_allowance"]/12,0);
				$spcl_allowance=round($r1["spcl_allowance"]/12,0);
				$empr_pf=$empr_pf=round($r1["empr_pf"]/12,0);
				$empr_esi=$r1["empr_esi"];
				$bonus=$r1["bonus"];
				$arrear=$r1["arrear"];
				$other_income=$r1["other_income"];
				$epf_contribution=round($r1["epf_contribution"]/12,0);
				$esi_contr=$r1["esi_contr"];
				$profession_tax=$r1["profession_tax"];
				$income_tax=$r1["income_tax"];
				$advances=$r1["advances"];
				$other_deduction=$r1["other_deduction"];
//				$gross=$basic_pay+$house_rent_allowance+$conveyance_allowance+$spcl_allowance+$bonus+$arrear+$other_income+$r1["med_allw"]+$r1["lta"]+$r1["tel_reim"]+$r1["internet_reim"]+$r1["med_ins"];
				$gross=$basic_pay+$house_rent_allowance+$conveyance_allowance+$spcl_allowance;
				$deduct=$epf_contribution+$esi_contr+$profession_tax+$income_tax;
				$ctc=$gross+($empr_pf+$empr_esi+$advances);
				$total+=$gross;
				if($i%2==1)
					$str.="<tr bgcolor='#b4b4b4'>";
				else
					$str.="<tr>";
				$str.="	<td align=right><font size=2>".$r1["emp_name"]." (".$r1["emp_id"].")"."</td>
						<td align=right><font size=2>".$basic_pay."</td>
						<td align=right><font size=2>".$house_rent_allowance."</td>
						<td align=right><font size=2>".$conveyance_allowance."</td>
						<td align=right><font size=2>".$spcl_allowance."</td>
						<td align=right><font size=2>".$empr_pf."</td>
						<td align=right><font size=2>".$empr_esi."</td>
						<td align=right><font size=2>".$bonus."</td>
						<td align=right><font size=2>".$arrear."</td>
						<td align=right><font size=2>".$other_income."</td>
						<!--<td align=right><font size=2>".$r1["med_allw"]."</td>
						<td align=right><font size=2>".$r1["lta"]."</td>
						<td align=right><font size=2>".$r1["tel_reim"]."</td>
						<td align=right><font size=2>".$r1["internet_reim"]."</td>
						<td align=right><font size=2>".$r1["med_ins"]."</td>-->
						<td align=right><font size=2>".$epf_contribution."</td>
						<td align=right><font size=2>".$esi_contr."</td>
						<td align=right><font size=2>".$profession_tax."</td>
						<td align=right><font size=2>".$income_tax."</td>
						<td align=right><font size=2>".$advances."</td>
						<td align=right><font size=2>".$other_deduction."</td>
						<td align=right><font size=2><b>".$gross."</td>
					</tr>";
				$i++;
			}
			$str.="<tr bgcolor=grey><td colspan=16><b>Total Cost to Company</b></td><td><b>".$total."</b></td></tr>";
			$str.="</table>";
			//$str.=$query;
			return $str;
		}

		function getEmpSalSummaryDt($start,$end,$emp)
		{
			$i=0;
			$total=0;
			$str="";
			$str.="<table border=0 cellpadding='10' width=100%>
					<tr bgcolor=grey>
						<td rowspan=2 align=center><font size=2>Employee Name</td>
						<td rowspan=2 align=center><font size=2>Period</td>
						<td colspan=9 align=center><font size=2>Earnings</td>
						<!--<td colspan=5 align=center><font size=2>Reimbursements</td> -->
						<td colspan=6 align=center><font size=2>Deductions</td>
						<td rowspan=2 align=center><font size=2>Net Salary</td>
					</tr>
					<tr bgcolor=grey>
						<td align=center><font size=1>Basic</td>
						<td align=center><font size=1>HRA</td>
						<td align=center><font size=1>Conveyance</td>
						<td align=center><font size=1>Spcl. Allowance</td>
						<td align=center><font size=1>Employer Contribution to PF</td>
						<td align=center><font size=1>Employer Contribution to ESI</td>
						<td align=center><font size=1>Bonus</td>
						<td align=center><font size=1>Arrear Salary</td>
						<td align=center><font size=1>Other Income</td>
						<!--<td align=center><font size=1>Medical Allowance</td>
						<td align=center><font size=1>LTA</td>
						<td align=center><font size=1>Telephone</td>
						<td align=center><font size=1>Internet</td>
						<td align=center><font size=1>Medical Insurance</td>-->
						<td align=center><font size=1>EPF Contribution</td>
						<td align=center><font size=1>ESI Contribution</td>
						<td align=center><font size=1>Prof. Tax</td>
						<td align=center><font size=1>Income Tax</td>
						<td align=center><font size=1>Advances</td>
						<td align=center><font size=1>Other Deductions</td>
					</tr>";
			$query="SELECT B.emp_name, A.*, C.month_srl from (SELECT `emp_id`, salary_year, salary_month, `basic_pay`, `house_rent_allowance`, `conveyance_allowance`, `spcl_allowance`, `empr_pf`, `empr_esi`, `bonus`, `arrear`, `other_income`, `med_allw`, `lta`, `tel_reim`, `internet_reim`, `med_ins`, `epf_contribution`, `esi_contr`, `profession_tax`, `income_tax`, `advances`, `other_deduction` FROM `salary_master` 
					WHERE 
					emp_id in (select distinct emp_id from emp_master where active=1)
					and published=1) A, emp_master B, month_master C 
					where A.emp_id=B.emp_id 
					and B.active=1 
					and A.salary_month=C.month_name";
			if($start!="")
			{
				$start_dt=substr($start,0,4)."-".substr($start,5,2);
				$query .= "
					and concat(A.salary_year,'-',C.month_srl)>='".$start_dt."'";
			}
			if($end!="")
			{
				$end_dt=substr($end,0,4)."-".substr($end,5,2);
				$query .= "
					and concat(A.salary_year,'-',C.month_srl)<='".$end_dt."'";
			}
			if($emp!="")
			{
				$query .= "
					and A.emp_id='".$emp."'";
			}
			$query .= "
					order by A.salary_year, C.month_srl";
			//echo $query;
			$q1=mysql_query($query);
			while($r1=mysql_fetch_array($q1))
			{
				$basic_pay=$r1["basic_pay"];
				$house_rent_allowance=$r1["house_rent_allowance"];
				$conveyance_allowance=$r1["conveyance_allowance"];
				$spcl_allowance=$r1["spcl_allowance"];
				$empr_pf=$empr_pf=$r1["empr_pf"];
				$empr_esi=$r1["empr_esi"];
				$bonus=$r1["bonus"];
				$arrear=$r1["arrear"];
				$other_income=$r1["other_income"];
				$epf_contribution=$r1["epf_contribution"];
				$esi_contr=$r1["esi_contr"];
				$profession_tax=$r1["profession_tax"];
				$income_tax=$r1["income_tax"];
				$advances=$r1["advances"];
				$other_deduction=$r1["other_deduction"];
				$gross=$basic_pay+$house_rent_allowance+$conveyance_allowance+$spcl_allowance+$bonus+$arrear+$other_income;
				$ctc=$gross+($epf_contribution+$esi_contr+$advances);
				$ded=$profession_tax+$income_tax+$epf_contribution+$esi_contr+$other_deduction;
				$net=$gross-$ded;
				$total+=$gross;
				if($i%2==1)
					$str.="<tr bgcolor='#b4b4b4'>";
				else
					$str.="<tr>";
				$str.="	<td align=right><font size=2>".$r1["emp_name"]." (".$r1["emp_id"].")"."</td>
						<td align=right><font size=2>".$r1["salary_month"]." ".$r1["salary_year"]."</td>
						<td align=right><font size=2>".$basic_pay."</td>
						<td align=right><font size=2>".$house_rent_allowance."</td>
						<td align=right><font size=2>".$conveyance_allowance."</td>
						<td align=right><font size=2>".$spcl_allowance."</td>
						<td align=right><font size=2>".$empr_pf."</td>
						<td align=right><font size=2>".$empr_esi."</td>
						<td align=right><font size=2>".$bonus."</td>
						<td align=right><font size=2>".$arrear."</td>
						<td align=right><font size=2>".$other_income."</td>
						<!--<td align=right><font size=2>".$r1["med_allw"]."</td>
						<td align=right><font size=2>".$r1["lta"]."</td>
						<td align=right><font size=2>".$r1["tel_reim"]."</td>
						<td align=right><font size=2>".$r1["internet_reim"]."</td>
						<td align=right><font size=2>".$r1["med_ins"]."</td>-->
						<td align=right><font size=2>".$epf_contribution."</td>
						<td align=right><font size=2>".$esi_contr."</td>
						<td align=right><font size=2>".$profession_tax."</td>
						<td align=right><font size=2>".$income_tax."</td>
						<td align=right><font size=2>".$advances."</td>
						<td align=right><font size=2>".$other_deduction."</td>
						<td align=right><font size=2><b>".$net."</td>
					</tr>";
				$i++;
			}
			$str.="<tr bgcolor=grey><td colspan=17><b>Total Cost to Company</b></td><td><b>".$total."</b></td></tr>";
			$str.="</table>";
			//$str.=$query;
			return $str;
		}
		
		function getEmpList()
		{
			$i=0;
			$total=0;
			$str="";
			$str.="<table border=0 cellpadding='10' width=100%>
					<tr bgcolor=grey>
						<td rowspan=2 align=center><font size=2>Employee Name</td>
						<td colspan=10 align=center><font size=2>Earnings</td>
						<td colspan=5 align=center><font size=2>Reimbursements</td>
						<td colspan=6 align=center><font size=2>Deductions</td>
						<td rowspan=2 align=center><font size=2>CTC</td>
					</tr>
					<tr bgcolor=grey>
						<td align=center><font size=1>Basic</td>
						<td align=center><font size=1>HRA</td>
						<td align=center><font size=1>Conveyance</td>
						<td align=center><font size=1>Spcl. Allowance</td>
						<td align=center><font size=1>Employer Contribution to PF</td>
						<td align=center><font size=1>Employer Contribution to ESI</td>
						<td align=center><font size=1>Gratuity</td>
						<td align=center><font size=1>Bonus</td>
						<td align=center><font size=1>Arrear Salary</td>
						<td align=center><font size=1>Other Income</td>
						<td align=center><font size=1>Medical Allowance</td>
						<td align=center><font size=1>LTA</td>
						<td align=center><font size=1>Telephone</td>
						<td align=center><font size=1>Internet</td>
						<td align=center><font size=1>Medical Insurance</td>
						<td align=center><font size=1>EPF Contribution</td>
						<td align=center><font size=1>ESI Contribution</td>
						<td align=center><font size=1>Prof. Tax</td>
						<td align=center><font size=1>Income Tax</td>
						<td align=center><font size=1>Advances</td>
						<td align=center><font size=1>Other Deductions</td>
					</tr>";
			$query="SELECT B.emp_name, A.* from (SELECT `emp_id`, `basic_pay`, `house_rent_allowance`, `conveyance_allowance`, `spcl_allowance`, `empr_pf`, `empr_esi`, `gratuity`, `bonus`, `arrear`, `other_income`, `med_allw`, `lta`, `tel_reim`, `internet_reim`, `med_ins`, `epf_contribution`, `esi_contr`, `profession_tax`, `income_tax`, `advances`, `other_deduction` FROM `emp_sal_dtl` 
					WHERE 
					emp_id in (select distinct emp_id from emp_master where active=1)
					and active=1) A, emp_master B 
					where A.emp_id=B.emp_id 
					and B.active=1";
			$q1=mysql_query($query);
			while($r1=mysql_fetch_array($q1))
			{
				$basic_pay=$r1["basic_pay"];
				$house_rent_allowance=$r1["house_rent_allowance"];
				$conveyance_allowance=$r1["conveyance_allowance"];
				$spcl_allowance=$r1["spcl_allowance"];
				$empr_pf=$empr_pf=$r1["empr_pf"];
				$empr_esi=12*$r1["empr_esi"];
				$gratuity=$r1["gratuity"];
				$bonus=$r1["bonus"];
				$arrear=$r1["arrear"];
				$other_income=$r1["other_income"];
				$epf_contribution=$r1["epf_contribution"];
				$esi_contr=12*$r1["esi_contr"];
				$profession_tax=12*$r1["profession_tax"];
				$income_tax=12*$r1["income_tax"];
				$advances=$r1["advances"];
				$other_deduction=12*$r1["other_deduction"];
				$gross=$basic_pay+$house_rent_allowance+$conveyance_allowance+$spcl_allowance+$gratuity+$bonus+$arrear+$other_income+$r1["med_allw"]+$r1["lta"]+$r1["tel_reim"]+$r1["internet_reim"]+$r1["med_ins"];
				$ctc=$gross+($empr_pf+$empr_esi+$advances);
				$total+=$ctc;
				if($i%2==1)
					$str.="<tr bgcolor='#b4b4b4'>";
				else
					$str.="<tr>";
				$str.="	<td align=right><font size=2>".$r1["emp_name"]." (".$r1["emp_id"].")"."</td>
						<td align=right><font size=2>".$basic_pay."</td>
						<td align=right><font size=2>".$house_rent_allowance."</td>
						<td align=right><font size=2>".$conveyance_allowance."</td>
						<td align=right><font size=2>".$spcl_allowance."</td>
						<td align=right><font size=2>".$empr_pf."</td>
						<td align=right><font size=2>".$empr_esi."</td>
						<td align=right><font size=2>".$gratuity."</td>
						<td align=right><font size=2>".$bonus."</td>
						<td align=right><font size=2>".$arrear."</td>
						<td align=right><font size=2>".$other_income."</td>
						<td align=right><font size=2>".$r1["med_allw"]."</td>
						<td align=right><font size=2>".$r1["lta"]."</td>
						<td align=right><font size=2>".$r1["tel_reim"]."</td>
						<td align=right><font size=2>".$r1["internet_reim"]."</td>
						<td align=right><font size=2>".$r1["med_ins"]."</td>
						<td align=right><font size=2>".$epf_contribution."</td>
						<td align=right><font size=2>".$esi_contr."</td>
						<td align=right><font size=2>".$profession_tax."</td>
						<td align=right><font size=2>".$income_tax."</td>
						<td align=right><font size=2>".$advances."</td>
						<td align=right><font size=2>".$other_deduction."</td>
						<td align=right><font size=2><b>".$ctc."</td>
					</tr>";
				$i++;
			}
			$str.="<tr bgcolor=grey><td colspan=22><b>Total Cost to Company</b></td><td><b>".$total."</b></td></tr>";
			$str.="</table>";
			//$str.=$query;
			return $str;
		}
		
		function RandomString()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = '';
			for ($i = 0; $i < 30; $i++) {
				$randstring .= $characters[rand(0, strlen($characters)-1)];
			}
			return $randstring;
		}
*/	}

?>