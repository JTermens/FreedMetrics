<?php

$header = "Meet our team";
$subheader = "We believe in a more accessible science.";
$title = "FreedMetrics - About us";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader,1));
?>


	 <div class="container">
		 <div class="row">
			 <div class="col-md-6">
				 <div class="card border-0 shadow my-5 col-lg-30 col-md-10 mx-auto">
					 <div class="card-body p-6">
						 <h2 class="s-title">David Sotillo</h2>
						 <br>
						 <p class="s-description text-center">
							<b>BSc in Biochemistry at Autonomous University of Barcelona</b>
						 <p class="s-description text-center">
							Experience in clinical analysis, immunology and molecular biology.
							<p class="s-description text-center">
							Interested in structural bioinformatics.
						</p>
						<img src="tpl/img/authors/david.png" alt="" class="img-fluid" style="border-radius: 10%" width="100%">
						<p class="s-description text-center">
							<br>
		    		<a href="https://www.linkedin.com/in/davidsotilllo/" target="_blank"><img src="tpl/img/linkedin_logo.png" alt="" class="img-fluid" width="15%"></a>
					 </div>
				 </div>
			 </div>
			 <div class="col-md-6">
					 <div class="card border-0 shadow my-5 col-lg-30 col-md-10 mx-auto">
           <div class="card-body p-3">
						 <h2 class="s-title">Joan Térmens</h2>
						 <br>
						 <p class="s-description text-center">
							<b>BSc in Physics at University of Barcelona</b>
 						 <p class="s-description text-center">
							 <br>
 							 Experience in biophysics, data analysis and phase transitions physics.
 							<p class="s-description text-center">
 						  	Interested in tissue dynamics and cell cooperation.
 						</p>
          	 <img src="tpl/img/authors/joan.jpeg" alt="" class="img-fluid" style="border-radius: 10%" width="98%">
						 <p class="s-description text-center">
							 <br>
						 <a href="https://www.linkedin.com/in/joan-t%C3%A9rmens-9909b0183/" target="_blank"><img src="tpl/img/linkedin_logo.png" alt="" class="img-fluid" width="15%"></a>
			 </div>
     </div>
     </div>
			 <div class="col-md-6">
					 <div class="card border-0 shadow my-5 col-lg-30 col-md-10 mx-auto">
            <div class="card-body p-3">
						 <h2 class="s-title">Miguel Luengo</h2>
						 <br>
						  <p class="s-description text-center">
							<b>BSc in Biosystems Engineering at Polytechnic University of Catalonia</b>
 						 <p class="s-description text-center">
 							Experience in mathematical and computational modelling in th field of epidemiology.
 							<p class="s-description text-center">
 							Interested in the application of agent-based models in the field of systems biology.
 						</p>
							<img src="tpl/img/authors/miguel.jpg" alt="" class="img-fluid" style="border-radius: 10%">
							<p class="s-description text-center">
 							 <br>
 						 <a href="https://www.linkedin.com/in/miguel-luengo-perez/" target="_blank"><img src="tpl/img/linkedin_logo.png" alt="" class="img-fluid" width="15%"></a>
					 </div>
				 </div>
       </div>
       <div class="col-md-6">
					 <div class="card border-0 shadow my-5 col-lg-30 col-md-10 mx-auto">
           <div class="card-body p-3">
						 <h2 class="s-title">Oscar Camacho</h2>
						 <br>
						 <p class="s-description text-center">
							<b>BSc in Biomedical Sciences at University of Barcelona</b>
						 <p class="s-description text-center">
							 Experience in molecular biology, biochemistry and genetics related to human pathology.
							<p class="s-description text-center">
							Interested in developmental and systems biology.
						</p>
						<br>
						<img src="tpl/img/authors/oscar.png" alt="" class="img-fluid" style="border-radius: 10%" width="96%"></a>
						 <p class="s-description text-center">
							 <br>
						  <a href="https://www.linkedin.com/in/oscar-camacho-69779060/" target="_blank"><img src="tpl/img/linkedin_logo.png" alt="" class="img-fluid" width="15%"></a>
			 	 		</div>
					 </div>
         </div>
			 </div>






<?php print(page_footer($_SESSION['pagename']));
