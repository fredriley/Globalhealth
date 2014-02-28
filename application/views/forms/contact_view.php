
				  <!-- CONTENT -->
				<p>If you would like to contact the Global Health project, please fill in the form below. All fields are required. Alternatively, you can email us directly: </p>
				<p><a href="mailto:&#099;&#097;&#116;&#114;&#105;&#110;&#046;&#101;&#118;&#097;&#110;&#115;&#064;&#110;&#111;&#116;&#116;&#105;&#110;&#103;&#104;&#097;&#109;&#046;&#097;&#099;&#046;&#117;&#107;">Catrin Evans</a>, Project Manager<br>
				   <?php echo $this->site_config->output_admin_email(); ?>, Website administrator</p>

				<form action="<?php echo base_url(); ?>php/formmail.php" method="POST" class="form-horizontal" id="frm_email" >
					<!-- anti-spambot @ mangling - see http://www.tectite.com/fmdoc/at_mangle.php -->
					<input type="hidden" name="recipients" value="fred.riley_@_gmail.com" />
					<input type="hidden" name="subject" value="Global Health site contact" />
					<input type="hidden" name="env_report" value="REMOTE_HOST,REMOTE_ADDR, HTTP_USER_AGENT,AUTH_TYPE,REMOTE_USER" />
					<input type="hidden" name="good_url" value="<?php echo base_url(); ?>form/thanks" />
					<input type="hidden" name="bad_url"  value="<?php echo base_url(); ?>form/error" />
						<p><label for="realname" class="label label-important">Your name</label><br>
						<input name="realname" id="realname" class="required" required	></p>
						
						<p><label for="email" class="label label-important">Your email</label><br>
						<input name="email" id="email" class="required email" required></p>
						
						<p><label for="message" class="label label-important">Your message</label><br>
						<textarea name="message" id="message" class="required" required></textarea></p>
					<input type="submit" value="Submit" class="btn" >
				
				
				</form>
							
				<!-- END CONTENT -->

			
