import 'package:farm_rental/farmer/profile.dart';
import 'package:farm_rental/farmer/viewfarm.dart';
import 'package:flutter/material.dart';
import 'package:curved_navigation_bar/curved_navigation_bar.dart';

import 'confirm_order.dart';
import 'home.dart';

class CurvedNavbar extends StatefulWidget {
  final int userId;

  const CurvedNavbar({Key? key, required this.userId}) : super(key: key);

  @override
  _CurvedNavbarState createState() => _CurvedNavbarState();
}

class _CurvedNavbarState extends State<CurvedNavbar> {
  int _currentIndex = 0; // Index of the current page, changed to 0 for AddPage

  late List<Widget> _pages;

  @override
  void initState() {
    super.initState();
    _pages = [
      AddFarmPage(userId: widget.userId), // Pass the userId
      FarmList(userId: widget.userId),
      ViewFarm(userId: widget.userId), // Pass the userId instead of null
      Profile(),
    ];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: AnimatedSwitcher(
        duration: Duration(milliseconds: 300),
        transitionBuilder: (Widget child, Animation<double> animation) {
          return FadeTransition(opacity: animation, child: child);
        },
        child: _pages[_currentIndex],
      ),
      bottomNavigationBar: CurvedNavigationBar(
        backgroundColor: Colors.transparent,
        buttonBackgroundColor: Colors.teal,
        color: Colors.teal,
        animationDuration: const Duration(milliseconds: 300),
        items: const <Widget>[
          Icon(Icons.add, size: 26, color: Colors.white),
          Icon(Icons.remove_red_eye_rounded, size: 26, color: Colors.white),
          Icon(Icons.view_list, size: 26, color: Colors.white), // Icon for the farm list page
          Icon(Icons.person, size: 26, color: Colors.white),
        ],
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
      ),
    );
  }
}
