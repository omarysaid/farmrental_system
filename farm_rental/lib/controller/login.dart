import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:shared_preferences/shared_preferences.dart'; // Import SharedPreferences
import '../configure/configure.dart';
import '../farmer/Homepage.dart';
import '../renter/Homepage.dart';
import '../renter/home.dart';

class LoginController {
  Future<void> login(BuildContext context, String email, String password) async {
    if (email.isEmpty || password.isEmpty) {
      _showToast('Please enter your email and password.');
      return;
    }

    const String apiUrl = '${Config.baseUrl}/APIs/login.php';

    final response = await http.post(
      Uri.parse(apiUrl),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'email': email,
        'password': password,
      }),
    );

    if (response.statusCode == 200) {
      Map<String, dynamic> responseBody = jsonDecode(response.body);

      if (responseBody.containsKey('success') && responseBody['success']) {
        if (responseBody.containsKey('role')) {
          String role = responseBody['role'];

          // Extract and store additional user information
          int userId = int.parse(responseBody['user_id']);
          String fullname = responseBody['fullname'];
          String region = responseBody['region'];
          String district = responseBody['district'];
          String phone = responseBody['phone'];
          String userEmail = responseBody['email'];

          // Save user information to SharedPreferences
          SharedPreferences prefs = await SharedPreferences.getInstance();
          prefs.setInt('userId', userId);
          prefs.setString('fullname', fullname);
          prefs.setString('region', region);
          prefs.setString('district', district);
          prefs.setString('phone', phone);
          prefs.setString('email', userEmail);

          // Show loading indicator before navigating
          showDialog(
            context: context,
            barrierDismissible: false,
            builder: (BuildContext context) {
              return Center(
                child: CircularProgressIndicator(),
              );
            },
          );

          // Delay the navigation to simulate loading
          await Future.delayed(Duration(seconds: 2)); // Adjust delay time as needed

          // Navigate based on role after hiding loading indicator
          Navigator.pop(context); // Dismiss loading indicator
          if (role == 'Farmer') {
            Navigator.pushReplacement(
              context,
              MaterialPageRoute(
                  builder: (context) => CurvedNavbar(userId: userId)), // Pass the userId
            );
          } else if (role == 'Renter') {
            Navigator.pushReplacement(
              context,
              MaterialPageRoute(
                  builder: (context) => CurveNavbar(userId: userId)),
            );
          }
          return;
        } else {
          _showToast('Role information missing.');
        }
      } else if (responseBody.containsKey('message')) {
        _showToast(responseBody['message']);
      } else {
        _showToast('Unknown error occurred. Please try again.');
      }
    } else {
      _showToast('Failed to log in. Please try again.');
    }
  }

  void _showToast(String message) {
    Fluttertoast.showToast(
      msg: message,
      toastLength: Toast.LENGTH_SHORT,
      gravity: ToastGravity.BOTTOM,
      backgroundColor: Colors.red,
      textColor: Colors.white,
    );
  }
}
