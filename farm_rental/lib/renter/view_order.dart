import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import '../configure/configure.dart';

class ViewOrders extends StatefulWidget {
  final int userId;

  ViewOrders({required this.userId});

  @override
  _ViewOrdersState createState() => _ViewOrdersState();
}

class _ViewOrdersState extends State<ViewOrders> {
  List<dynamic> orders = [];
  bool isLoading = true;
  String? errorMessage;

  @override
  void initState() {
    super.initState();
    fetchOrders();
  }

  Future<void> fetchOrders() async {
    final url = '${Config.baseUrl}/APIs/vieworder_byId.php?user_id=${widget.userId}';

    try {
      final response = await http.get(Uri.parse('$url?user_id=${widget.userId}'));

      if (response.statusCode == 200) {
        final responseBody = json.decode(response.body);

        if (responseBody['success']) {
          setState(() {
            orders = responseBody['orders'];
            isLoading = false;
          });
        } else {
          setState(() {
            errorMessage = responseBody['message'];
            isLoading = false;
          });
        }
      } else {
        setState(() {
          errorMessage = 'Failed to load orders. Error: ${response.statusCode}';
          isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        errorMessage = 'Exception occurred: $e';
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        title: Text(
          'My Orders',
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
          valueColor: AlwaysStoppedAnimation<Color>(Colors.teal),
        ),
      )
          : errorMessage != null
          ? Center(
        child: Text(
          errorMessage!,
          style: TextStyle(color: Colors.red, fontSize: 18),
          textAlign: TextAlign.center,
        ),
      )
          : orders.isEmpty
          ? Center(
        child: Text(
          'No orders found',
          style: TextStyle(fontSize: 18),
        ),
      )
          : ListView.builder(
        itemCount: orders.length,
        itemBuilder: (context, index) {
          final order = orders[index];
          return GestureDetector(
            onTap: () {
              // Handle tap on order
            },
            child: OrderCard(order: order),
          );
        },
      ),
    );
  }
}

class OrderCard extends StatelessWidget {
  final dynamic order;

  OrderCard({required this.order});

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: EdgeInsets.symmetric(horizontal: 8.0, vertical: 4.0),
      elevation: 6.0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10.0),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          ClipRRect(
            borderRadius: BorderRadius.vertical(top: Radius.circular(10.0)),
            child: Image.network(
              order['farm_image_url'] ?? '',
              height: 150,
              fit: BoxFit.cover,
              errorBuilder: (context, error, stackTrace) => Icon(Icons.error, size: 150),
            ),
          ),
          Padding(
            padding: EdgeInsets.all(4.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Order Date: ${order['order_date'] ?? 'N/A'}',
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 14.0,
                  ),
                ),
                OrderDetailRow(
                  icon: Icons.date_range,
                  label: 'Start Date',
                  value: order['start_date'] != null
                      ? order['start_date'].toString()
                      : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.date_range,
                  label: 'End Date',
                  value: order['end_date'] != null
                      ? order['end_date'].toString()
                      : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.attach_money,
                  label: 'Total Amount',
                  value: order['total_amount'] != null
                      ? '\Tsh ${order['total_amount']}'
                      : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.location_on,
                  label: 'Region',
                  value: order['region'] != null ? order['region'].toString() : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.location_city,
                  label: 'District',
                  value: order['district'] != null ? order['district'].toString() : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.eco,
                  label: 'Fertile',
                  value: order['fertile'] != null ? order['fertile'].toString() : 'N/A',
                ),
                OrderDetailRow(
                  icon: Icons.info,
                  label: 'Order Status',
                  value: order['status'] != null ? order['status'].toString() : 'N/A',
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class OrderDetailRow extends StatelessWidget {
  final IconData icon;
  final String label;
  final String value;

  OrderDetailRow({required this.icon, required this.label, required this.value});

  @override
  Widget build(BuildContext context) {
    Color statusColor = Colors.black; // Default color
    String statusText = value; // Default status text

    // Check the status value and set the text and color accordingly
    if (label == 'Order Status') {
      if (value == '1') {
        statusText = 'Confirmed';
        statusColor = Colors.green; // Confirmed status
      } else if (value == '0') {
        statusText = 'Pending';
        statusColor = Colors.red; // Pending status
      }
    }

    return ListTile(
      contentPadding: EdgeInsets.symmetric(horizontal: 4.0, vertical: 0.0), // Minimal padding
      leading: Icon(icon, color: Colors.teal, size: 20),
      title: RichText(
        text: TextSpan(
          style: TextStyle(fontSize: 12.0, color: Colors.black),
          children: [
            TextSpan(text: '$label: '),
            TextSpan(
              text: statusText,
              style: TextStyle(color: statusColor), // Apply status color here
            ),
          ],
        ),
      ),
    );
  }
}
