<?php
// Start sessie
session_start();

// Verbinden met database
require 'config.php';

// Routes
require 'routes/web.php';
