<h3>REST class</h3>
<p>The REST class has the following public functions:</p>
<ul>
<li><strong>get_function()</strong><p>This function is responsible to return the script tried to access in the URL</p></li>
<li><strong>get_data()</strong><p>This function is responsible to return the array of data that was send in HTTP GET/POST method</p></li>
<li><strong>get_http()</strong><p>This method returns the http method (get/post) used to send the data to the server</p></li>
<li><strong>get_http_scheme()</strong><p>This method is responsible to get the http scheme used (http/https)</p></li>
<li><strong>respond($dataset, $_code)</strong><p>This method is responsible to send back the $dataset array as JSON object with the http status code from $_code. It also get the code message from the gstar_msg($_code) function</p></li>
</ul>
<br/>
<h3>Handler Class</h3>
<p>The handler class in h_rest.php file does the following:<br>The run() function gets the script tried to access, the data sent, the http method used and the http scheme used. It checks if the function exists in the name of a function and executes it. After getting a result from these process, it calls the response() funtion of the REST object and sends the dataset.</p>
<br/>
<p>For more description about the RESTful Architecture, check out my <a href="http://sudocoding.xyz/restfull-implementation-using-php/" target="_blank" >blog.</a></p>
