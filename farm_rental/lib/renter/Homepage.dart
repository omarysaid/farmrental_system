import 'package:farm_rental/farmer/profile.dart';
import 'package:farm_rental/renter/view_order.dart';
import 'package:flutter/material.dart';
import 'package:curved_navigation_bar/curved_navigation_bar.dart';
import 'home.dart';

class CurveNavbar extends StatefulWidget {
  final int userId;

  const CurveNavbar({Key? key, required this.userId}) : super(key: key);

  @override
  _CurveNavbarState createState() => _CurveNavbarState();
}

class _CurveNavbarState extends State<CurveNavbar> {
  int _currentIndex = 0; // Index of the current page, changed to 0 for AddPage

  late List<Widget> _pages;

  @override
  void initState() {
    super.initState();
    _pages = [
      ViewFarm(),
      ViewOrders(userId: widget.userId),
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
          Icon(Icons.landscape, size: 26, color: Colors.white),// Changed icon for View Farm
          Icon(Icons.shopping_cart_outlined, size: 26, color: Colors.white),
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
