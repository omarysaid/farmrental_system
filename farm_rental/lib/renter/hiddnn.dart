// import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http;
// import 'package:intl/intl.dart';
// import 'dart:convert';
// import 'package:fluttertoast/fluttertoast.dart';
//
// import '../configure/configure.dart';
//
// class OrderFarm extends StatefulWidget {
//   final int userId;
//   final int farmId;
//   final Map<String, dynamic> farm;
//
//   OrderFarm({required this.userId, required this.farmId, required this.farm});
//
//   @override
//   _OrderFarmState createState() => _OrderFarmState();
// }
//
// class _OrderFarmState extends State<OrderFarm> {
//   final _formKey = GlobalKey<FormState>();
//   late String startDate = '';
//   late String endDate = '';
//   late String totalAmount = '';
//
//   void showToast(String message, Color bgColor) {
//     Fluttertoast.showToast(
//       msg: message,
//       toastLength: Toast.LENGTH_LONG,
//       gravity: ToastGravity.BOTTOM,
//       backgroundColor: bgColor,
//       textColor: Colors.white,
//       fontSize: 16.0,
//     );
//   }
//
//   Future<void> _placeOrder() async {
//     final url = '${Config.baseUrl}/APIs/addorder.php';
//
//     // Proceed with placing the order
//     final response = await http.post(Uri.parse(url), body: {
//       'user_id': widget.userId.toString(),
//       'farm_id': widget.farmId.toString(),
//       'start_date': startDate,
//       'end_date': endDate,
//       'total_amount': totalAmount,
//     });
//
//     if (response.statusCode == 200) {
//       final responseBody = response.body;
//       final parsedResponse = json.decode(responseBody);
//
//       if (parsedResponse['success']) {
//         showToast(parsedResponse['message'], Colors.green); // Success message
//       } else {
//         showToast('This farm has already been ordered.', Colors.red); // Error message
//       }
//     } else {
//       showToast('Error placing order. Please try again later.', Colors.red); // Generic error message
//     }
//   }
//
//   Future<void> _selectDate(BuildContext context, String field) async {
//     final DateTime? picked = await showDatePicker(
//       context: context,
//       initialDate: DateTime.now(),
//       firstDate: DateTime(2022),
//       lastDate: DateTime(2030),
//     );
//     if (picked != null && picked != DateTime.now()) {
//       setState(() {
//         if (field == 'start') {
//           startDate = DateFormat('yyyy-MM-dd').format(picked);
//         } else {
//           endDate = DateFormat('yyyy-MM-dd').format(picked);
//         }
//       });
//     }
//   }
//
//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       backgroundColor: Colors.grey[200],
//       appBar: AppBar(
//         title: Text(
//           'Order Farms',
//           style: TextStyle(
//             fontWeight: FontWeight.bold,
//             color: Colors.white,
//           ),
//         ),
//         centerTitle: true,
//         flexibleSpace: Container(
//           decoration: BoxDecoration(
//             gradient: LinearGradient(
//               colors: [Colors.teal, Colors.teal],
//               begin: Alignment.topLeft,
//               end: Alignment.bottomRight,
//             ),
//             borderRadius: BorderRadius.vertical(
//               bottom: Radius.circular(30),
//             ),
//           ),
//         ),
//         shape: RoundedRectangleBorder(
//           borderRadius: BorderRadius.vertical(
//             bottom: Radius.circular(30),
//           ),
//         ),
//
//       ),
//       body: Padding(
//         padding: const EdgeInsets.all(16.0),
//         child: Form(
//           key: _formKey,
//           child: SingleChildScrollView(
//             child: Column(
//               crossAxisAlignment: CrossAxisAlignment.start,
//               children: [
//                 Hero(
//                   tag: 'farmImage${widget.farm['farm_id']}',
//                   child: Material(
//                     elevation: 4,
//                     borderRadius: BorderRadius.circular(15),
//                     child: ClipRRect(
//                       borderRadius: BorderRadius.circular(15),
//                       child: Image.network(
//                         widget.farm['farm_image'],
//                         width: double.infinity,
//                         height: 200,
//                         fit: BoxFit.cover,
//                       ),
//                     ),
//                   ),
//                 ),
//                 SizedBox(height: 16),
//                 Text(
//                   'From-Region: ${widget.farm['district']} ',
//                   style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Colors.black87),
//                 ),
//                 Text(
//                   'district: ${widget.farm['district']} ',
//                   style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Colors.black87),
//                 ),
//                 SizedBox(height: 8),
//                 Row(
//                   children: [
//                     Icon(Icons.landscape, size: 16, color: Colors.black87),
//                     SizedBox(width: 5),
//                     Flexible(
//                       child: Text(
//                         'Size: ${widget.farm['size']} hectares',
//                         style: TextStyle(fontSize: 16, color: Colors.black87),
//                         overflow: TextOverflow.ellipsis,
//                       ),
//                     ),
//                   ],
//                 ),
//                 SizedBox(height: 8),
//                 Row(
//                   children: [
//                     Icon(Icons.monetization_on, size: 16, color: Colors.black87),
//                     SizedBox(width: 5),
//                     Flexible(
//                       child: Text(
//                         'Price:Tsh ${widget.farm['price']}',
//                         style: TextStyle(fontSize: 16, color: Colors.black87),
//                         overflow: TextOverflow.ellipsis,
//                       ),
//                     ),
//                   ],
//                 ),
//                 SizedBox(height: 8),
//                 Row(
//                   children: [
//                     Icon(Icons.park, size: 16, color: Colors.black87),
//                     SizedBox(width: 5),
//                     Flexible(
//                       child: Text(
//                         'Fertile-soil: ${widget.farm['fertile']}',
//                         style: TextStyle(fontSize: 16, color: Colors.black87),
//                         overflow: TextOverflow.ellipsis,
//                         maxLines: 10,
//                       ),
//                     ),
//                   ],
//                 ),
//                 SizedBox(height: 16),TextFormField(
//                   readOnly: true,
//                   decoration: InputDecoration(
//                     labelText: 'Start Date',
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0), // Border color when not focused
//                     ),
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0), // Border color when focused
//                     ),
//                     prefixIcon: Icon(Icons.calendar_today,
//                       color: Colors.teal,),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please select start date';
//                     }
//                     return null;
//                   },
//                   onTap: () => _selectDate(context, 'start'),
//                   controller: TextEditingController(text: startDate),
//                 ),
//
//
//                 SizedBox(height: 16),Container(
//                   decoration: BoxDecoration(
//                     border: Border.all(color: Colors.teal, width: 2.0), // Border color when not focused
//                     borderRadius: BorderRadius.circular(8.0), // Adjust border radius as needed
//                   ),
//                   child: TextFormField(
//                     readOnly: true,
//                     decoration: InputDecoration(
//                       labelText: 'End Date',
//                       prefixIcon: Icon(Icons.calendar_today,
//                         color: Colors.teal,),
//                       border: InputBorder.none, // Hide the default border
//                     ),
//                     validator: (value) {
//                       if (value == null || value.isEmpty) {
//                         return 'Please select end date';
//                       }
//                       return null;
//                     },
//                     onTap: () => _selectDate(context, 'end'),
//                     controller: TextEditingController(text: endDate),
//                   ),
//                 ),
//
//                 SizedBox(height: 16),TextFormField(
//                   decoration: InputDecoration(
//                     labelText: 'Total Amount',
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0), // Border color when not focused
//                     ),
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0), // Border color when focused
//                     ),
//                     prefixIcon: Icon(Icons.monetization_on,
//                       color: Colors.teal,),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter total amount';
//                     }
//                     return null;
//                   },
//                   onSaved: (value) {
//                     totalAmount = value!;
//                   },
//                 ),
//
//                 SizedBox(height: 16),
//                 Center(
//                   child: ElevatedButton(
//                     onPressed: () {
//                       if (_formKey.currentState!.validate()) { _formKey.currentState!.save();
//                       _placeOrder();
//                       }
//                     },
//                     child: Text(
//                       'Confirm',
//                       style: TextStyle(color: Colors.white),
//                     ),
//                     style: ElevatedButton.styleFrom(
//                       backgroundColor: Colors.teal,
//                       padding: EdgeInsets.symmetric(horizontal: 150, vertical: 16),
//                       textStyle: TextStyle(fontSize: 20),
//                     ),
//                   ),
//                 ),
//               ],
//             ),
//           ),
//         ),
//       ),
//     );
//   }
// }
