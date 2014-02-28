				<?php $this -> load -> view('resource/contribute_submenu_view', $active_submenu); ?>
				  <!-- CONTENT -->
				<p>Please use the form below to suggest a resource for the Global Health repository. Alternatively, you can email us directly: </p>
				<p><a href="mailto:&#099;&#097;&#116;&#114;&#105;&#110;&#046;&#101;&#118;&#097;&#110;&#115;&#064;&#110;&#111;&#116;&#116;&#105;&#110;&#103;&#104;&#097;&#109;&#046;&#097;&#099;&#046;&#117;&#107;">Catrin Evans</a>, Project Manager<br>
				   <a href="mailto:&#102;&#114;&#101;&#100;&#046;&#114;&#105;&#108;&#101;&#121;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;">Fred Riley</a>, Website administrator</p>
				   <p> Fields labelled <span class="label label-important">as important</span> are required, and you'll be slapped on the wrist if you leave them empty. </p>

					<form action="<?php echo base_url(); ?>php/formmail.php" method="POST" class="form-horizontal" id="frm_email" >
					<!-- anti-spambot @ mangling - see http://www.tectite.com/fmdoc/at_mangle.php -->
					<input type="hidden" name="recipients" value="fred.riley_@_gmail.com" />
					<input type="hidden" name="subject" value="Global Health resource suggestion" />
					<input type="hidden" name="env_report" value="REMOTE_HOST,REMOTE_ADDR, HTTP_USER_AGENT,AUTH_TYPE,REMOTE_USER" />
					<input type="hidden" name="good_url" value="<?php echo base_url(); ?>form/thanks" />
					<input type="hidden" name="bad_url"  value="<?php echo base_url(); ?>form/error" />
					<fieldset>
						<legend>Resource information</legend>
							<p><label for="title" class="label label-important"><strong>Title</strong></label><br>
							<input type="text" name="title" id="title" class="required" required ></p>
							
							<p><label for="url" class="label label-important"><strong>URL</strong></label><br>
							<input type="text" name="url" id="url" class="required url" required ></p>	
							
							<p><label for="description" class="label label-important"><strong>Brief description</strong></label><br>
							<textarea name="description" id="description" class="required" required rows="6" cols="50" ></textarea><br>
							<span class="label label-warning">NB:</span> <em>Plain text only - no HTML accepted</em></p>
							
					</fieldset>
					<fieldset>
						<legend>About you</legend>
						<p><label for="realname" class="label label-important"><strong>Your name</strong></label><br>
						<input name="realname" id="realname" class="required" required	></p>
						
						<p><label for="email" class="label label-important"><strong>Your email</strong></label><br>
						<input name="email" id="email" class="required email" required ></p>
						
					</fieldset>
					<input type="submit" value="Submit suggestion" class="btn" >
				
				
				</form>
					
										
				<!-- END CONTENT -->


			
