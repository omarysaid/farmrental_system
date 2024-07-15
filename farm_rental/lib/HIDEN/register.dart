// import 'dart:convert';
// import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http;
// import 'package:fluttertoast/fluttertoast.dart';
// import '../controller/login.dart';
// import 'login_screen.dart';
//
// class SignupPage extends StatefulWidget {
//   const SignupPage({Key? key}) : super(key: key);
//
//   @override
//   _SignupPageState createState() => _SignupPageState();
// }
//
// class _SignupPageState extends State<SignupPage> {
//   String? _userType;
//   TextEditingController _nameController = TextEditingController();
//   TextEditingController _regionController = TextEditingController();
//   TextEditingController _phoneController = TextEditingController();
//   TextEditingController _emailController = TextEditingController();
//   TextEditingController _passwordController = TextEditingController();
//   TextEditingController _confirmPasswordController = TextEditingController();
//   final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
//
//   Future<void> _registerUser() async {
//     if (_nameController.text.isEmpty &&
//         _regionController.text.isEmpty &&
//         _phoneController.text.isEmpty &&
//         _emailController.text.isEmpty &&
//         _passwordController.text.isEmpty &&
//         _confirmPasswordController.text.isEmpty) {
//       Fluttertoast.showToast(
//         msg: 'Please enter all fields',
//         toastLength: Toast.LENGTH_LONG,
//         gravity: ToastGravity.BOTTOM,
//         backgroundColor: Colors.red,
//         textColor: Colors.white,
//       );
//       return;
//     }
//
//     if (!_formKey.currentState!.validate()) {
//       return;
//     }
//
//     final String apiUrl = 'http://192.168.109.183/farm/APIs/register.php';
//
//     final response = await http.post(
//       Uri.parse(apiUrl),
//       headers: <String, String>{
//         'Content-Type': 'application/json; charset=UTF-8',
//       },
//       body: jsonEncode(<String, String>{
//         'fullname': _nameController.text,
//         'region': _regionController.text,
//         'phone': _phoneController.text,
//         'email': _emailController.text,
//         'password': _passwordController.text,
//         'role': _userType ?? '',
//       }),
//     );
//
//     if (response.statusCode == 200) {
//       Fluttertoast.showToast(
//         msg: 'Successfully registered!',
//         toastLength: Toast.LENGTH_SHORT,
//         gravity: ToastGravity.BOTTOM,
//         backgroundColor: Colors.green,
//         textColor: Colors.white,
//       );
//       await Future.delayed(Duration(seconds: 2));
//       Navigator.pushReplacement(
//         context,
//         MaterialPageRoute(builder: (context) => Login()),
//       );
//     } else {
//       showDialog(
//         context: context,
//         builder: (BuildContext context) {
//           return AlertDialog(
//             title: Text('Error'),
//             content: Text('Failed to register user. Please try again.'),
//             actions: [
//               TextButton(
//                 onPressed: () {
//                   Navigator.of(context).pop();
//                 },
//                 child: Text('OK'),
//               ),
//             ],
//           );
//         },
//       );
//     }
//   }
//
//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       body: SingleChildScrollView(
//         child: Container(
//           decoration: BoxDecoration(
//             gradient: LinearGradient(
//               begin: Alignment.topLeft,
//               end: Alignment.bottomRight,
//               colors: [
//                 Color(0xFFF0FFFF),
//                 Color(0xFFF0FFFF),
//               ],
//             ),
//           ),
//           padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 20),
//           child: Form(
//             key: _formKey,
//             child: Column(
//               mainAxisAlignment: MainAxisAlignment.spaceEvenly,
//               crossAxisAlignment: CrossAxisAlignment.stretch,
//               children: <Widget>[
//                 Column(
//                   children: <Widget>[
//                     SizedBox(height: 80),
//                     Text(
//                       'Sign up',
//                       style: TextStyle(
//                         fontSize: 20,
//                         fontWeight: FontWeight.bold,
//                         color: Colors.teal,
//                         fontFamily: 'Montserrat',
//                       ),
//                       textAlign: TextAlign.center,
//                     ),
//                   ],
//                 ),
//                 const SizedBox(height: 20),
//                 TextFormField(
//                   controller: _nameController,
//                   decoration: InputDecoration(
//                     hintText: "Full Name",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(20),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.person),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter your full name';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 TextFormField(
//                   controller: _regionController,
//                   decoration: InputDecoration(
//                     hintText: "Region",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(20),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.location_on),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter your region';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 TextFormField(
//                   controller: _phoneController,
//                   decoration: InputDecoration(
//                     hintText: "Phone",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(18),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.phone),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter your phone number';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 TextFormField(
//                   controller: _emailController,
//                   decoration: InputDecoration(
//                     hintText: "Email",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(18),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.email),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter an email address';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 TextFormField(
//                   controller: _passwordController,
//                   decoration: InputDecoration(
//                     hintText: "Password",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(18),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.lock),
//                   ),
//                   obscureText: true,
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter a password';
//                     }
//                     if (value.length < 6) {
//                       return 'Password must be at least 6 characters long';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 TextFormField(
//                   controller: _confirmPasswordController,
//                   decoration: InputDecoration(
//                     hintText: "Confirm Password",
//                     border: OutlineInputBorder(
//                       borderRadius: BorderRadius.circular(18),
//                       borderSide: BorderSide.none,
//                     ),
//                     fillColor: Colors.teal[100],
//                     filled: true,
//                     prefixIcon: const Icon(Icons.lock),
//                   ),
//                   obscureText: true,
//                   validator: (value) {
//                     if (value != _passwordController.text) {
//                       return 'Passwords do not match';
//                     }
//                     return null;
//                   },
//                 ),
//                 const SizedBox(height: 15),
//                 Row(
//                   children: <Widget>[
//                     Text("Are you : "),
//                     Radio(
//                       value: "renter",
//                       groupValue: _userType,
//                       onChanged: (value) {
//                         setState(() {
//                           _userType = value.toString();
//                         });
//                       },
//                     ),
//                     Text("Renter"),
//                     Radio(
//                       value: "farmer",
//                       groupValue: _userType,
//                       onChanged: (value) {
//                         setState(() {
//                           _userType = value.toString();
//                         });
//                       },
//                     ),
//                     Text("Farmer"),
//                   ],
//                 ),
//                 Container(
//                   padding: const EdgeInsets.only(top: 3, left: 3),
//                   child: Container(
//                     height: 50,
//                     decoration: BoxDecoration(
//                       gradient: LinearGradient(
//                         begin: Alignment.topLeft,
//                         end: Alignment.bottomRight,
//                         colors: [
//                           Colors.blue,
//                           Colors.teal,
//                         ],
//                       ),
//                       borderRadius: BorderRadius.circular(18),
//                     ),
//                     child: ElevatedButton(
//                       onPressed: _registerUser,
//                       child: const Text(
//                         "Register",
//                         style: TextStyle(fontSize: 20, color: Colors.white),
//                       ),
//                       style: ElevatedButton.styleFrom(
//                         shape: const StadiumBorder(),
//                         padding: const EdgeInsets.symmetric(vertical: 6),
//                         backgroundColor: Colors.transparent,
//                       ),
//                     ),
//                   ),
//                 ),
//                 const Center(child: Text("Or")),
//                 Row(
//                   mainAxisAlignment: MainAxisAlignment.center,
//                   children: <Widget>[
//                     const Text(
//                       "Already have an account?",
//                       style: TextStyle(fontSize: 20, color: Colors.teal),
//                     ),
//                     TextButton(
//                       onPressed: () {
//                         Navigator.push(
//                           context,
//                           MaterialPageRoute(builder: (context) => Login()),
//                         );
//                       },
//                       child: const Text(
//                         "Login",
//                         style: TextStyle(color: Colors.teal, fontSize: 20),
//                       ),
//                     )
//                   ],
//                 )
//               ],
//             ),
//           ),
//         ),
//       ),
//     );
//   }
// }
