import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../configure/configure.dart';
import 'order_farm.dart';


class ViewFarm extends StatefulWidget {
  @override
  _ViewFarmState createState() => _ViewFarmState();
}

class _ViewFarmState extends State<ViewFarm> {
  List<Map<String, dynamic>> farms = [];
  bool isLoading = true;
  String errorMessage = '';

  Future<void> fetchFarms() async {
    try {
      final response = await http.get(Uri.parse('${Config.baseUrl}/APIs/viewFarm.php'));
      if (response.statusCode == 200) {
        setState(() {
          farms = List<Map<String, dynamic>>.from(jsonDecode(response.body)['farms']);
          isLoading = false;
        });
      } else {
        setState(() {
          isLoading = false;
          errorMessage = 'Failed to load farms: ${response.statusCode}';
        });
      }
    } catch (e) {
      setState(() {
        isLoading = false;
        errorMessage = 'Network error: $e';
      });
    }
  }

  @override
  void initState() {
    super.initState();
    fetchFarms();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        title: Text(
          'View Farms',
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        centerTitle: true,
        flexibleSpace: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: [Colors.teal, Colors.teal],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            borderRadius: BorderRadius.vertical(
              bottom: Radius.circular(30),
            ),
          ),
        ),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(
            bottom: Radius.circular(30),
          ),
        ),
        automaticallyImplyLeading: false,
      ),
      body: isLoading
          ? Center(
        child: CircularProgressIndicator(
          strokeWidth: 5.0,
        ),
      )
          : errorMessage.isNotEmpty
          ? Center(
        child: Text(
          errorMessage,
          style: TextStyle(color: Colors.red, fontSize: 18),
          textAlign: TextAlign.center,
        ),
      )
          : farms.isEmpty
          ? Center(
        child: Text(
          'No farms available',
          style: TextStyle(fontSize: 18),
        ),
      )
          : ListView.builder(
        itemCount: farms.length,
        itemBuilder: (context, index) {
          final farm = farms[index];
          final imageUrl = farm['farm_image'] ?? '';
          return Card(
            margin: EdgeInsets.symmetric(vertical: 10, horizontal: 15),
            elevation: 5,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(15),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                ClipRRect(
                  borderRadius: BorderRadius.vertical(top: Radius.circular(15)),
                  child: Image.network(
                    imageUrl,
                    width: double.infinity,
                    height: 200,
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stackTrace) =>
                        Icon(Icons.broken_image, size: 200),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(15.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Farm from Region: ${farm['region']}' ?? 'No region specified',
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 20,
                        ),
                      ),
                      Text(
                        'District: ${farm['district']}' ?? 'No district  specified',

                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 20,
                        ),
                      ),
                      SizedBox(height: 10),
                      Row(
                        children: [
                          Icon(Icons.landscape, size: 20,
                          color: Colors.teal),
                          SizedBox(width: 15),
                          Expanded(child: Text('Size: ${farm['size']} hectares')),
                        ],
                      ),
                      SizedBox(height: 5),
                      Row(
                        children: [
                          Icon(Icons.monetization_on, size: 20,
                              color: Colors.teal),
                          SizedBox(width: 15),
                          Expanded(child: Text('Price:(Tsh ${farm['price']})')),
                        ],
                      ),
                      SizedBox(height: 5),
                      Row(
                        children: [
                          Icon(Icons.park, size: 20,
                              color: Colors.teal),
                          SizedBox(width: 15),
                          Expanded(child: Text('Fertile-soil: ${farm['fertile']}')),
                        ],
                      ),
                      SizedBox(height: 10),
                      Center(
                        child: ElevatedButton(
                          onPressed: () async { // Make the function async
                            // Fetch the user ID from SharedPreferences
                            SharedPreferences prefs = await SharedPreferences.getInstance();
                            int userId = prefs.getInt('userId') ?? 0; // Default value if userId is not found

                            // Get the farm ID from the current farm data
                            int farmId = farm['farm_id'];

                            // Navigate to OrderFarm screen with userId, farmId, and farm data
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => OrderFarm(userId: userId, farmId: farmId, farm: farm),
                              ),
                            );
                          },
                          child: Text('Order'),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}


