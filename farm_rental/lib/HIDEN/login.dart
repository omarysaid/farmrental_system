// import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http;
// import 'dart:convert';
// import 'package:fluttertoast/fluttertoast.dart'; // Import fluttertoast package
//
// import '../farmer/home.dart';
// import '../renter/home.dart';
// import 'register.dart';
//
// class Login extends StatefulWidget {
//   const Login({Key? key}) : super(key: key);
//
//   @override
//   State<Login> createState() => _LoginState();
// }
//
// class _LoginState extends State<Login> {
//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       body: Container(
//         child: Stack(
//           children: [
//             Container(
//               width: MediaQuery.of(context).size.width,
//               height: MediaQuery.of(context).size.height / 2.5,
//               decoration: BoxDecoration(
//                 gradient: LinearGradient(
//                   begin: Alignment.topLeft,
//                   end: Alignment.bottomRight,
//                   colors: [
//                     Colors.grey,
//                     Colors.teal,
//                   ],
//                 ),
//               ),
//             ),
//             Container(
//               margin: EdgeInsets.only(top: MediaQuery.of(context).size.height / 3),
//               height: MediaQuery.of(context).size.height / 1,
//               width: MediaQuery.of(context).size.width,
//               decoration: BoxDecoration(
//                 gradient: LinearGradient(
//                   begin: Alignment.topLeft,
//                   end: Alignment.bottomRight,
//                   colors: [
//                     Color(0xFFF0FFFF),
//                     Color(0xFFF0FFFF),
//                   ],
//                 ),
//                 borderRadius: BorderRadius.only(
//                   topLeft: Radius.circular(30),
//                   topRight: Radius.circular(30),
//                 ),
//               ),
//               child: Text(""),
//             ),
//             Container(
//               margin: EdgeInsets.only(top: 20.0, left: 20.0, right: 20.0),
//               child: Column(
//                 children: [
//                   Center(
//                     child: Image.asset(
//                       "assets/images/logo.png",
//                       width: MediaQuery.of(context).size.width / 1,
//                       fit: BoxFit.cover,
//                     ),
//                   ),
//                   Expanded(
//                     child: LoginScreen(),
//                   ),
//                 ],
//               ),
//             )
//           ],
//         ),
//       ),
//     );
//   }
// }
//
// class LoginScreen extends StatelessWidget {
//   final TextEditingController _emailController = TextEditingController();
//   final TextEditingController _passwordController = TextEditingController();
//
//   Future<void> _login(BuildContext context) async {
//     // Retrieve email and password from text fields
//     String email = _emailController.text.trim();
//     String password = _passwordController.text.trim();
//
//     // Validate email and password fields
//     if (email.isEmpty) {
//       _showToast('Please enter your email.'); // Show toast for validation error
//       return;
//     }
//     if (password.isEmpty) {
//       _showToast('Please enter your password.'); // Show toast for validation error
//       return;
//     }
//
//     final String apiUrl = 'http://192.168.109.183/farm/APIs/login.php';
//
//     final response = await http.post(
//       Uri.parse(apiUrl),
//       headers: <String, String>{
//         'Content-Type': 'application/json; charset=UTF-8',
//       },
//       body: jsonEncode(<String, String>{
//         'email': email,
//         'password': password,
//       }),
//     );
//
//     if (response.statusCode == 200) {
//       // Decode the response body
//       Map<String, dynamic> responseBody = jsonDecode(response.body);
//       String role = responseBody['role'];
//
//       if (role == 'farmer') {
//         // Navigate to farmer home page if role is farmer
//         Navigator.pushReplacement(
//           context,
//           MaterialPageRoute(builder: (context) => const MyHomePage(title: 'Flutter Demo Home Page')),
//         );
//       } else if (role == 'renter') {
//         // Navigate to renter home page if role is renter
//         Navigator.pushReplacement(
//           context,
//           MaterialPageRoute(builder: (context) => const HomePage(title: 'Flutter Demo Home Page')),
//         );
//       } else {
//         // Show error message for invalid credentials
//         _showToast('Invalid credentials. Please try again.');
//       }
//     } else {
//       // Show error message for failed login attempt
//       _showToast('Failed to log in. Please try again.');
//     }
//   }
//
//   void _showToast(String message) {
//     Fluttertoast.showToast(
//       msg: message,
//       toastLength: Toast.LENGTH_SHORT,
//       gravity: ToastGravity.BOTTOM,
//       backgroundColor: Colors.red,
//       textColor: Colors.white,
//     );
//   }
//
//   @override
//   Widget build(BuildContext context) {
//     return ListView(
//       padding: EdgeInsets.all(10.0),
//       children: [
//         SizedBox(height: 20),
//         Text(
//           'Sign In',
//           style: TextStyle(
//             fontSize: 20,
//             fontWeight: FontWeight.bold,
//             color: Colors.teal,
//             fontFamily: 'Montserrat',
//           ),
//           textAlign: TextAlign.center,
//         ),
//         SizedBox(height: 20),
//         Text(
//           'Enter your credentials here',
//           style: TextStyle(
//             fontSize: 20,
//             fontWeight: FontWeight.bold,
//             color: Colors.teal,
//             fontFamily: 'Montserrat',
//           ),
//           textAlign: TextAlign.center,
//         ),
//         SizedBox(height: 20),
//         Container(
//           decoration: BoxDecoration(
//             color: Colors.teal[100],
//             borderRadius: BorderRadius.circular(18.0), // Rounded corners for username field
//           ),
//           child: TextField(
//             controller: _emailController,
//             decoration: InputDecoration(
//               hintText: 'Email',
//               prefixIcon: Icon(Icons.email_rounded),
//               border: InputBorder.none, // No border
//             ),
//           ),
//         ),
//         SizedBox(height: 20),
//         Container(
//           decoration: BoxDecoration(
//             color: Colors.teal[100],
//             borderRadius: BorderRadius.circular(18.0), // Rounded corners for password field
//           ),
//           child: TextField(
//             controller: _passwordController,
//             obscureText: true,
//             decoration: InputDecoration(
//               hintText: 'Password',
//               prefixIcon: Icon(Icons.lock),
//               border: InputBorder.none, // No border
//             ),
//           ),
//         ),
//         SizedBox(height: 20),
//         Container(
//           height: 45,
//           decoration: BoxDecoration(
//             borderRadius: BorderRadius.circular(16.0),
//             gradient: LinearGradient(
//               begin: Alignment.topLeft,
//               end: Alignment.bottomRight,
//               colors: [
//                 Colors.blue,
//                 Colors.teal,
//               ],
//             ),
//           ),
//           child: ElevatedButton(
//             onPressed: () {
//               _login(context);
//             },
//             style: ElevatedButton.styleFrom(
//               shape: const StadiumBorder(),
//               padding: const EdgeInsets.symmetric(vertical: 6),
//               backgroundColor: Colors.transparent, // Set background color to transparent
//             ),
//             child: Text(
//               'Login',
//               style: TextStyle(fontSize: 20, color: Colors.white), // Increase font size of 'Login'
//             ),
//           ),
//         ),
//         SizedBox(height: 100),
//         GestureDetector(
//           onTap: () {
//             Navigator.push(
//               context,
//               MaterialPageRoute(builder: (context) => SignupPage()),
//             );
//           },
//           child: Text(
//             "Don't you have an account? Sign up",
//             textAlign: TextAlign.center,
//             style: TextStyle(
//               color: Colors.teal,
//               fontSize: 20,
//             ),
//           ),
//         ),
//       ],
//     );
//   }
// }
//
// void main() {
//   runApp(MaterialApp(
//     home: Login(),
//   ));
// }