<?php
	class My_Thread extends Thread
	{

	  public function run() {
	    echo "Thread running...\n";
	    // Faire quelque-chose de lent...
	  }

	}

	$t = new My_Thread();
	$t->start();