import 'package:farm_rental/farmer/viewfarm.dart';
import 'package:flutter/material.dart';

class FarmDetails extends StatelessWidget {
  final Farm farm;

  const FarmDetails({Key? key, required this.farm}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        title: Text(
          'Farm Details',
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
      body: SingleChildScrollView(
        padding: EdgeInsets.symmetric(horizontal: 20, vertical: 10),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildImageSection(),
            SizedBox(height: 20),
            Text(
              farm.description,
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w600,
                color: Colors.grey[800],
                height: 1.5,
              ),
            ),
            SizedBox(height: 20),
            _buildDetailRow(Icons.landscape, 'Size in hectares', farm.size),
            _buildDetailRow(Icons.attach_money, 'Price (Tshs)', '${farm.price}'),
            _buildDetailRow(Icons.verified_user, 'Farm-Status', farm.status == 1 ? "Approved" : "Not Approved"),
            _buildDetailRow(Icons.grass, 'Fertile soil', farm.fertile),
          ],
        ),
      ),
    );
  }

  Widget _buildImageSection() {
    return Stack(
      alignment: Alignment.bottomCenter,
      children: [
        ClipRRect(
          borderRadius: BorderRadius.circular(20),
          child: Hero(
            tag: 'farmImage${farm.farmId}',
            child: Image.network(
              farm.farmImage,
              width: double.infinity,
              height: 300,
              fit: BoxFit.cover,
            ),
          ),
        ),
        Container(
          width: double.infinity,
          color: Colors.black.withOpacity(0.4),
          padding: EdgeInsets.symmetric(vertical: 8),
          child: Text(
            'Farm Image',
            textAlign: TextAlign.center,
            style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.white),
          ),
        ),
      ],
    );
  }

  Widget _buildDetailRow(IconData icon, String title, String detail) {
    Color statusColor = detail == "Not Approved"
        ? Colors.red
        : (detail == "Approved" ? Colors.green : Colors.black);

    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          Icon(icon, color: Colors.teal, size: 24),
          SizedBox(width: 15),
          Text(
            '$title: ',
            style: TextStyle(
              fontWeight: FontWeight.bold,
              color: Colors.grey[700],
              fontSize: 18,
            ),
          ),
          Expanded(
            child: Text(
              detail,
              style: TextStyle(
                fontSize: 18,
                color: statusColor,
                height: 1.5,
              ),
              maxLines: title == 'Fertile soil' ? 10 : 1,
              overflow: TextOverflow.ellipsis,
            ),
          ),
        ],
      ),
    );
  }
}
