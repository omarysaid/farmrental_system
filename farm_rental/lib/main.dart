import 'package:farm_rental/screen/login_screen.dart';
import 'package:flutter/material.dart';

import 'controller/login.dart';


void main() {
  runApp(MaterialApp(
    debugShowCheckedModeBanner:false,
    home: Login(), // Setting LoginScreen as the initial route
    theme: ThemeData(
      primaryColor: Colors.teal, // Set the primary color to teal
      colorScheme: ColorScheme.fromSwatch(primarySwatch: Colors.teal), // Use teal color scheme
    ),
  ));
}
