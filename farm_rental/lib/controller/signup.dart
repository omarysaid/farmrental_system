import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../configure/configure.dart';
import '../screen/login_screen.dart';

void main() {
  runApp(MyApp());
}

class RegisterController {
  Future<List<String>> fetchRegions() async {
    const String regionsUrl = '${Config.baseUrl}/Regions/Regions.php?action=get_regions';
    final response = await http.get(Uri.parse(regionsUrl));

    if (response.statusCode == 200) {
      List<dynamic> regions = jsonDecode(response.body);
      return regions.map((region) => region.toString()).toList();
    } else {
      throw Exception('Failed to load regions');
    }
  }

  Future<List<String>> fetchDistricts(String region) async {
    final String districtsUrl = '${Config.baseUrl}/Regions/Regions.php?action=get_districts&region=$region';
    final response = await http.get(Uri.parse(districtsUrl));

    if (response.statusCode == 200) {
      List<dynamic> districts = jsonDecode(response.body);
      return districts.map((district) => district.toString()).toList();
    } else {
      throw Exception('Failed to load districts');
    }
  }

  Future<void> registerUser({
    required String fullname,
    required String region,
    required String district,
    required String phone,
    required String email,
    required String password,
    required String confirmPassword,
    required String role,
    required BuildContext context,
  }) async {
    if (fullname.isEmpty ||
        region.isEmpty ||
        district.isEmpty ||
        phone.isEmpty ||
        email.isEmpty ||
        password.isEmpty ||
        confirmPassword.isEmpty ||
        role.isEmpty) {
      Fluttertoast.showToast(
        msg: 'Please enter all fields',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
      return;
    }

    if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(email)) {
      Fluttertoast.showToast(
        msg: 'Please enter a valid email address',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
      return;
    }

    if (password.length < 6) {
      Fluttertoast.showToast(
        msg: 'Password must be at least 6 characters long',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
      return;
    }

    if (password != confirmPassword) {
      Fluttertoast.showToast(
        msg: 'Passwords do not match',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
      return;
    }

    const String apiUrl = '${Config.baseUrl}/APIs/register.php';

    final response = await http.post(
      Uri.parse(apiUrl),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'fullname': fullname,
        'region': region,
        'district': district,
        'phone': phone,
        'email': email,
        'password': password,
        'role': role,
      }),
    );

    if (response.statusCode == 200) {
      Fluttertoast.showToast(
        msg: 'Successfully registered!',
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.green,
        textColor: Colors.white,
      );
      await Future.delayed(Duration(seconds: 1));
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => Login()),
      );
    } else {
      showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            title: Text('Error'),
            content: Text('Failed to register user. Please try again.'),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.of(context).pop();
                },
                child: Text('OK'),
              ),
            ],
          );
        },
      );
    }
  }
}

class RegisterPage extends StatefulWidget {
  @override
  _RegisterPageState createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final _controller = RegisterController();
  String? selectedRegion;
  String? selectedDistrict;
  List<String> regions = [];
  List<String> districts = [];
  TextEditingController fullnameController = TextEditingController();
  TextEditingController phoneController = TextEditingController();
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  TextEditingController confirmPasswordController = TextEditingController();
  TextEditingController roleController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _loadRegions();
  }

  Future<void> _loadRegions() async {
    try {
      final fetchedRegions = await _controller.fetchRegions();
      setState(() {
        regions = fetchedRegions;
      });
    } catch (e) {
      // Handle the error
      Fluttertoast.showToast(
        msg: 'Failed to load regions',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
    }
  }

  Future<void> _loadDistricts(String region) async {
    try {
      final fetchedDistricts = await _controller.fetchDistricts(region);
      setState(() {
        districts = fetchedDistricts;
      });
    } catch (e) {
      // Handle the error
      Fluttertoast.showToast(
        msg: 'Failed to load districts',
        toastLength: Toast.LENGTH_LONG,
        gravity: ToastGravity.BOTTOM,
        backgroundColor: Colors.red,
        textColor: Colors.white,
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Register')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: SingleChildScrollView(
          child: Column(
            children: [
              TextFormField(
                controller: fullnameController,
                decoration: InputDecoration(labelText: 'Full Name'),
              ),
              SizedBox(height: 16),
              DropdownButton<String>(
                hint: Text('Select Region'),
                value: selectedRegion,
                items: regions.map((region) {
                  return DropdownMenuItem<String>(
                    value: region,
                    child: Text(region),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    selectedRegion = value;
                    selectedDistrict = null; // Reset district selection
                    districts = []; // Clear districts
                  });
                  if (value != null) {
                    _loadDistricts(value);
                  }
                },
              ),
              SizedBox(height: 16),
              if (selectedRegion != null)
                DropdownButton<String>(
                  hint: Text('Select District'),
                  value: selectedDistrict,
                  items: districts.map((district) {
                    return DropdownMenuItem<String>(
                      value: district,
                      child: Text(district),
                    );
                  }).toList(),
                  onChanged: (value) {
                    setState(() {
                      selectedDistrict = value;
                    });
                  },
                ),
              SizedBox(height: 16),
              TextFormField(
                controller: phoneController,
                decoration: InputDecoration(labelText: 'Phone'),
                keyboardType: TextInputType.phone,
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: emailController,
                decoration: InputDecoration(labelText: 'Email'),
                keyboardType: TextInputType.emailAddress,
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: passwordController,
                decoration: InputDecoration(labelText: 'Password'),
                obscureText: true,
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: confirmPasswordController,
                decoration: InputDecoration(labelText: 'Confirm Password'),
                obscureText: true,
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: roleController,
                decoration: InputDecoration(labelText: 'Role'),
              ),
              SizedBox(height: 16),
              ElevatedButton(
                onPressed: () {
                  _controller.registerUser(
                    fullname: fullnameController.text,
                    region: selectedRegion ?? "",
                    district: selectedDistrict ?? "",
                    phone: phoneController.text,
                    email: emailController.text,
                    password: passwordController.text,
                    confirmPassword: confirmPasswordController.text,
                    role: roleController.text,
                    context: context,
                  );
                },
                child: Text('Register'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Registration App',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: RegisterPage(),
    );
  }
}
