<ul class="nav">
                <!--
                <li>
                  <a href="news.php">
                    最新訊息
                  </a>
                </li>
                <li class="divider-vertical"></li>
                -->
                <li>
                  <a href="faq.php">
                    合作條款
                  </a>
                </li>
                <li class="divider-vertical"></li>
                <li>
                  <a href="myorder.php">
                    成效查詢
                  </a>
                </li>
                <li class="divider-vertical"></li>
                <?php if(!isset($_SESSION['ALLIANCE_ID'])){ ?>
                <li>
                  <a href="login.php">
                    登入聯盟會員
                  </a>
                </li>                
                <li class="divider-vertical"></li>
				<?php }else{ ?>
                <li>
                  <a href="member_pwchange.php">
                    修改會員密碼
                  </a>
                </li>
                <li class="divider-vertical"></li>
                <li>
                  <a href="modify.php">
                    修改會員資料
                  </a>
                </li>
                <li class="divider-vertical"></li>
				<li>
                  <a href="logout.php">
                    登出
                  </a>
                </li>
                <li class="divider-vertical"></li>
                <?php } ?>
                <li>
                  <a href="service.php">
                    聯絡我們
                  </a>
                </li>                
                <li class="divider-vertical"></li>
                <li>
                  <a href="http://www.iwine.com.tw/index.php">
                    iWine
                  </a>
                </li>                
                <li class="divider-vertical"></li>
              </ul>