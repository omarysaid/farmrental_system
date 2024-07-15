import 'package:farm_rental/screen/register_screen.dart';
import 'package:flutter/material.dart';
import '../controller/login.dart';



class Login extends StatefulWidget {
  const Login({Key? key}) : super(key: key);

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final LoginController _loginController = LoginController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        child: Stack(
          children: [
            Container(
              width: MediaQuery.of(context).size.width,
              height: MediaQuery.of(context).size.height / 2.5,
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [
                    Colors.grey,
                    Colors.teal,
                  ],
                ),
              ),
            ),
            Container(
              margin: EdgeInsets.only(top: MediaQuery.of(context).size.height / 3),
              height: MediaQuery.of(context).size.height / 1,
              width: MediaQuery.of(context).size.width,
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [
                    Color(0xFFF0FFFF),
                    Color(0xFFF0FFFF),
                  ],
                ),
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(30),
                  topRight: Radius.circular(30),
                ),
              ),
              child: Text(""),
            ),
            Container(
              margin: EdgeInsets.only(top: 20.0, left: 20.0, right: 20.0),
              child: Column(
                children: [
                  Center(
                    child: Image.asset(
                      "assets/images/logo.png",
                      width: MediaQuery.of(context).size.width / 1,
                      fit: BoxFit.cover,
                    ),
                  ),
                  Expanded(
                    child: LoginScreen(
                      emailController: _emailController,
                      passwordController: _passwordController,
                      loginController: _loginController,
                    ),
                  ),
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}

class LoginScreen extends StatelessWidget {
  final TextEditingController emailController;
  final TextEditingController passwordController;
  final LoginController loginController;

  LoginScreen({
    required this.emailController,
    required this.passwordController,
    required this.loginController,
  });

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: EdgeInsets.all(10.0),
      children: [
        SizedBox(height: 20),
        Text(
          'Sign In',
          style: TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.bold,
            color: Colors.teal,
            fontFamily: 'Montserrat',
          ),
          textAlign: TextAlign.center,
        ),
        SizedBox(height: 20),
        Text(
          'Enter your credentials here',
          style: TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.bold,
            color: Colors.teal,
            fontFamily: 'Montserrat',
          ),
          textAlign: TextAlign.center,
        ),
        SizedBox(height: 20),
        Container(
          decoration: BoxDecoration(
            color: Colors.teal[100],
            borderRadius: BorderRadius.circular(18.0),
          ),
          child: TextField(
            controller: emailController,
            decoration: InputDecoration(
              hintText: 'Email',
              prefixIcon: Icon(Icons.email_rounded),
              border: InputBorder.none,
            ),
          ),
        ),
        SizedBox(height: 20),
        Container(
          decoration: BoxDecoration(
            color: Colors.teal[100],
            borderRadius: BorderRadius.circular(18.0),
          ),
          child: TextField(
            controller: passwordController,
            obscureText: true,
            decoration: InputDecoration(
              hintText: 'Password',
              prefixIcon: Icon(Icons.lock),
              border: InputBorder.none,
            ),
          ),
        ),
        SizedBox(height: 20),
        Container(
          height: 50,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(16.0),
            gradient: LinearGradient(
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
              colors: [
                Colors.blue,
                Colors.teal,
              ],
            ),
          ),
          child: ElevatedButton(
            onPressed: () {
              loginController.login(context, emailController.text, passwordController.text);
            },
            style: ElevatedButton.styleFrom(
              shape: const StadiumBorder(),
              padding: const EdgeInsets.symmetric(vertical: 6),
              backgroundColor: Colors.transparent,
            ),
            child: Text(
              'Login',
              style: TextStyle(fontSize: 20, color: Colors.white),
            ),
          ),
        ),
        SizedBox(height: 100),
        GestureDetector(
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => RegisterScreen()),
            );
          },
          child: Text(
            "Don't you have an account? Sign up",
            textAlign: TextAlign.center,
            style: TextStyle(
              color: Colors.teal,
              fontSize: 20,
            ),
          ),
        ),
      ],
    );
  }
}

void main() {
  runApp(MaterialApp(
    home: Login(),
  ));
}
