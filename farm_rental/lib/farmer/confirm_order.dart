import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../configure/configure.dart';

class ViewFarm extends StatefulWidget {
  final int userId;

  const ViewFarm({Key? key, required this.userId}) : super(key: key);

  @override
  _ViewFarmState createState() => _ViewFarmState();
}

class _ViewFarmState extends State<ViewFarm> {
  List<Map<String, dynamic>> farms = [];
  bool isLoading = true;
  String errorMessage = '';

  Future<void> fetchFarms() async {
    try {
      final response = await http.get(Uri.parse('${Config.baseUrl}/APIs/confirm_order.php?user_id=${widget.userId}'));
      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        final fetchedFarms = responseData['farms'];
        if (fetchedFarms != null) {
          setState(() {
            farms = List<Map<String, dynamic>>.from(fetchedFarms);
            isLoading = false;
          });
        } else {
          setState(() {
            farms = [];
            isLoading = false;
          });
        }
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

  Future<void> updateOrderStatus(int orderId, int status) async {
    try {
      final response = await http.post(
        Uri.parse('${Config.baseUrl}/APIs/confirm_order.php'),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          'order_id': orderId,
          'status': status,
        }),
      );

      if (response.statusCode == 200) {
        final responseBody = jsonDecode(response.body);
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(responseBody['message'])),
        );
        fetchFarms(); // Refresh the farm list
      } else {
        setState(() {
          errorMessage = 'Failed to update status: ${response.statusCode}';
        });
      }
    } catch (e) {
      setState(() {
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
        'View Orders',
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
    'No orders found',
    style: TextStyle(fontSize: 18),
    ),
    )
        : ListView.builder(
    itemCount: farms.length,
    itemBuilder: (context, index) {
    final farm = farms[index];
    final imageUrl = farm['farm_image_url'] ?? '';
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
    errorBuilder: (context, error, stackTrace) => Icon(Icons.broken_image, size: 200),
    ),
    ),
    Padding(
    padding: const EdgeInsets.all(15.0),
    child: Column(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
    Text(
    'Renter from Region: ${farm['region']}' ?? 'No region specified',
    style: TextStyle(
    fontWeight: FontWeight.bold,
    fontSize: 20,
    ),
    ),
    Text(
    'District: ${farm['district']}' ?? 'No district specified',
    style: TextStyle(
    fontWeight: FontWeight.bold,
    fontSize: 20,
    ),
    ),
    SizedBox(height: 10),
    Row(
    children: [
    Icon(Icons.landscape, size: 20, color: Colors.teal),
    SizedBox(width: 15),
    Expanded(child: Text('Farm-Size:( ${farm['size']} hectares)')),
    ],
    ),
    SizedBox(height: 5),
    Row(
    children: [
    Icon(Icons.monetization_on, size: 20, color: Colors.teal),
    SizedBox(width: 15),
    Expanded(child: Text('Renting Price:(Tsh ${farm['total_amount']})')),
    ],
    ),
      SizedBox(height: 5),
      Row(
        children: [
          Icon(Icons.phone, size: 20, color: Colors.teal),
          SizedBox(width: 15),
          Expanded(child: Text('Renter-Phone: ${farm['phone']}')),
        ],
      ),
      SizedBox(height: 10),
      Row(
        children: [
          Icon(Icons.event, size: 20, color: Colors.teal),
          SizedBox(width: 15),
          Expanded(child: Text('Ordering Date: ${farm['order_date']}')),
        ],
      ),
      SizedBox(height: 5),
      Row(
        children: [
          Icon(Icons.access_time, size: 20, color: Colors.teal),
          SizedBox(width: 15),
          Expanded(
            child: Text(
              farm['status'] != null ? 'Status: ${farm['status'] == 1 ? 'Confirmed' : 'Pending'}' : 'Status: Unknown',
              style: TextStyle(
                color: farm['status'] == 1 ? Colors.green : Colors.red,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
      SizedBox(height: 10),
      ElevatedButton(
        onPressed: () {
          final currentStatus = farm['status'];
          final newStatus = currentStatus == 1 ? 0 : 1;
          updateOrderStatus(farm['order_id'], newStatus);
        },
        child: Text('Confirm Order'),
      ),],
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
