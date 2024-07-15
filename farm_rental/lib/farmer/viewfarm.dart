import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../configure/configure.dart';
import 'farmDetails.dart';
 // Import the FarmDetails screen

class Farm {
  final int farmId;
  final int userId;
  final String size;
  final String description;
  final double price;
  final String document;
  final String farmImage;
  final int status;
  final String fertile;

  Farm({
    required this.farmId,
    required this.userId,
    required this.size,
    required this.description,
    required this.price,
    required this.document,
    required this.farmImage,
    required this.status,
    required this.fertile,
  });

  factory Farm.fromJson(Map<String, dynamic> json) {
    return Farm(
      farmId: json['farm_id'],
      userId: json['user_id'],
      size: json['size'],
      description: json['description'],
      price: json['price'] is String ? double.parse(json['price']) : json['price'].toDouble(),
      document: json['document'],
      farmImage: json['farm_image'],
      status: json['status'],
      fertile: json['fertile'],
    );
  }
}

class FarmList extends StatefulWidget {
  final int userId;

  const FarmList({Key? key, required this.userId}) : super(key: key);

  @override
  _FarmListState createState() => _FarmListState();
}

class _FarmListState extends State<FarmList> {
  late Future<List<Farm>> _futureFarms;

  @override
  void initState() {
    super.initState();
    _futureFarms = fetchFarmsByUserId(widget.userId);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        title: const Text(
          'Farm Details',
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        centerTitle: true,
        flexibleSpace: Container(
          decoration: const BoxDecoration(
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
        shape: const RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(
            bottom: Radius.circular(30),
          ),
        ),
        automaticallyImplyLeading: false,
      ),
      body: Center(
        child: FutureBuilder<List<Farm>>(
          future: _futureFarms,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const CircularProgressIndicator();
            } else if (snapshot.hasError) {
              return Text('Error: ${snapshot.error}');
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return const Text('No farms available.');
            } else {
              return ListView.builder(
                padding: const EdgeInsets.all(10),
                itemCount: snapshot.data?.length,
                itemBuilder: (context, index) {
                  Farm farm = snapshot.data![index];
                  return _buildFarmCard(farm);
                },
              );
            }
          },
        ),
      ),
    );
  }

  Widget _buildFarmCard(Farm farm) {
    return Card(
      elevation: 8,
      margin: const EdgeInsets.symmetric(vertical: 10),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(20),
      ),
      child: InkWell(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => FarmDetails(farm: farm),
            ),
          );
        },
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Hero(
              tag: 'farmImage${farm.farmId}',
              child: ClipRRect(
                borderRadius: const BorderRadius.vertical(top: Radius.circular(20)),
                child: Image.network(
                  farm.farmImage,
                  width: double.infinity,
                  height: 200,
                  fit: BoxFit.cover,
                ),
              ),
            ),
            Padding(
              padding: EdgeInsets.all(15),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    farm.description,
                    style: const TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                      color: Colors.black54,
                    ),
                  ),
                  const SizedBox(height: 10),
                  _buildDetailRow(Icons.landscape, 'Size in hectares', farm.size),
                  _buildDetailRow(Icons.attach_money, 'Price  Tsh', '${farm.price}'),
                  _buildDetailRow(Icons.verified_user, 'Farm-Status', farm.status == 1 ? "Approved" : "Not Approved"),

                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDetailRow(IconData icon, String title, String detail) {
    Color statusColor = detail == ("Not Approved")
        ? Colors.red
        : (detail == " Approved"
        ? Colors.green
        : Colors.black); // Color for status field

    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 5),
      child: Row(
        children: [
          Icon(icon, color: Colors.teal, size: 24),
          const SizedBox(width: 10),
          Text(
            '$title: ',
            style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey[700], fontSize: 16),
          ),
          Expanded(
            child: Text(
              detail,
              style: TextStyle(fontSize: 16, color: statusColor),
              overflow: TextOverflow.ellipsis,
            ),
          ),
        ],
      ),
    );
  }
}

Future<List<Farm>> fetchFarmsByUserId(int userId) async {
  final response = await http.get(
    Uri.parse('${Config.baseUrl}/APIs/viewfarm_byId.php?user_id=$userId'),
  );

  if (response.statusCode == 200) {
    final Map<String, dynamic> responseData = json.decode(response.body);

    if (responseData['success']) {
      final List<dynamic> farmsData = responseData['farms'];
      return farmsData.map((farm) => Farm.fromJson(farm)).toList();
    } else {
      throw Exception('Failed to load farms: ${responseData['message']}');
    }
  } else {
    throw Exception('Failed to load farms');
  }
}

void main() {
  runApp(MaterialApp(
    home: const FarmList(userId: 1), // Example userId
    theme: ThemeData(
      primaryColor: Colors.teal,
      hintColor: Colors.tealAccent,
      textTheme: const TextTheme(
        headline1: TextStyle(fontSize: 36.0, fontWeight: FontWeight.bold),
        headline6: TextStyle(fontSize: 18.0, fontStyle: FontStyle.italic),
        bodyText2: TextStyle(fontSize: 14.0, fontFamily: 'Hind'),
      ),
    ),
  ));
}
