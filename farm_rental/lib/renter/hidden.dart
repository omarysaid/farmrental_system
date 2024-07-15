// import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http;
// import 'package:intl/intl.dart';
// import 'dart:convert';
// import 'package:fluttertoast/fluttertoast.dart';
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
//   late String paymentMethod = 'Credit Card';
//
//   late String cardNumber = '';
//   late String cardExpiry = '';
//   late String cardCVV = '';
//   late String paypalEmail = '';
//   late String bankName = '';
//   late String bankAccountNumber = '';
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
//     final url = 'http://192.168.4.183/farmrental/APIs/addorder.php';
//     final response = await http.post(Uri.parse(url), body: {
//       'user_id': widget.userId.toString(),
//       'farm_id': widget.farmId.toString(),
//       'start_date': startDate,
//       'end_date': endDate,
//       'total_amount': totalAmount,
//       'payment_method': paymentMethod,
//       'card_number': cardNumber,
//       'card_expiry': cardExpiry,
//       'card_cvv': cardCVV,
//       'paypal_email': paypalEmail,
//       'bank_name': bankName,
//       'bank_account_number': bankAccountNumber,
//     });
//
//     if (response.statusCode == 200) {
//       final responseBody = response.body;
//       final parsedResponse = json.decode(responseBody);
//
//       if (parsedResponse['success']) {
//         showToast(parsedResponse['message'], Colors.green);
//       } else {
//         showToast(parsedResponse['message'], Colors.red);
//       }
//     } else {
//       showToast('Error placing order. Please try again later.', Colors.red);
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
//     if (picked != null) {
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
//   Widget _buildPaymentMethodFields() {
//     switch (paymentMethod) {
//       case 'Credit Card':
//         return Column(
//           children: [
//             TextFormField(
//               decoration: InputDecoration(
//                 labelText: 'Card Number',
//                 focusedBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 enabledBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 prefixIcon: Icon(Icons.credit_card),
//               ),
//               validator: (value) {
//                 if (value == null || value.isEmpty) {
//                   return 'Please enter card number';
//                 }
//                 return null;
//               },
//               onSaved: (value) {
//                 cardNumber = value ?? '';
//               },
//             ),
//             SizedBox(height: 16),
//             TextFormField(
//               decoration: InputDecoration(
//                 labelText: 'Card Expiry',
//                 focusedBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 enabledBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 prefixIcon: Icon(Icons.date_range),
//               ),
//               validator: (value) {
//                 if (value == null || value.isEmpty) {
//                   return 'Please enter card expiry';
//                 }
//                 return null;
//               },
//               onSaved: (value) {
//                 cardExpiry = value ?? '';
//               },
//             ),
//             SizedBox(height: 16),
//             TextFormField(
//               decoration: InputDecoration(
//                 labelText: 'Card CVV',
//                 focusedBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 enabledBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 prefixIcon: Icon(Icons.security),
//               ),
//               validator: (value) {
//                 if (value == null || value.isEmpty) {
//                   return 'Please enter card CVV';
//                 }
//                 return null;
//               },
//               onSaved: (value) {
//                 cardCVV = value ?? '';
//               },
//             ),
//           ],
//         );
//       case 'PayPal':
//         return TextFormField(
//           decoration: InputDecoration(
//             labelText: 'PayPal Email',
//             focusedBorder: OutlineInputBorder(
//               borderSide: BorderSide(color: Colors.teal, width: 2.0),
//             ),
//             enabledBorder: OutlineInputBorder(
//               borderSide: BorderSide(color: Colors.teal, width: 2.0),
//             ),
//             prefixIcon: Icon(Icons.email),
//           ),
//           validator: (value) {
//             if (value == null || value.isEmpty) {
//               return 'Please enter PayPal email';
//             }
//             return null;
//           },
//           onSaved: (value) {
//             paypalEmail = value ?? '';
//           },
//         );
//       case 'Bank Transfer':
//         return Column(
//           children: [
//             DropdownButtonFormField<String>(
//               decoration: InputDecoration(
//                 labelText: 'Bank Name',
//                 focusedBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 enabledBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 prefixIcon: Icon(Icons.account_balance),
//               ),
//               items: ['NMB', 'CRDB', 'NBC', 'TCB', 'Stanbic']
//                   .map((bank) => DropdownMenuItem(
//                 value: bank,
//                 child: Text(bank),
//               ))
//                   .toList(),
//               onChanged: (value) {
//                 setState(() {
//                   bankName = value ?? '';
//                 });
//               },
//               validator: (value) {
//                 if (value == null || value.isEmpty) {
//                   return 'Please select bank name';
//                 }
//                 return null;
//               },
//               onSaved: (value) {
//                 bankName = value ?? '';
//               },
//             ),
//             SizedBox(height: 16),
//             TextFormField(
//               decoration: InputDecoration(
//                 labelText: 'Bank Account Number',
//                 focusedBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 enabledBorder: OutlineInputBorder(
//                   borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                 ),
//                 prefixIcon: Icon(Icons.account_balance_wallet),
//               ),
//               validator: (value) {
//                 if (value == null || value.isEmpty) {
//                   return 'Please enter bank account number';
//                 }
//                 return null;
//               },
//               onSaved: (value) {
//                 bankAccountNumber = value ?? '';
//               },
//             ),
//           ],
//         );
//       default:
//         return Container();
//     }
//   }
//
//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       appBar: AppBar(
//         title: Text(
//           'Order Farm',
//           style: TextStyle(
//             fontWeight: FontWeight.bold,
//             color: Colors.white,
//           ),
//         ),
//         backgroundColor: Colors.teal,
//       ),
//       body: Container(
//         color: Colors.grey[200],
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
//                   widget.farm['region'] ?? 'No description',
//                   style: TextStyle(
//                     fontSize: 24,
//                     fontWeight: FontWeight.bold,
//                     color: Colors.black87,
//                   ),
//                 ),
//                 Text(
//                   widget.farm['district'] ?? 'No description',
//                   style: TextStyle(
//                     fontSize: 24,
//                     fontWeight: FontWeight.bold,
//                     color: Colors.black87,
//                   ),
//                 ),
//                 SizedBox(height: 8),
//                 Row(
//                   children: [
//                     Icon(Icons.landscape, size: 16, color: Colors.black87),
//                     SizedBox(width: 5),
//                     Flexible(
//                       child: Text(
//                         'Size: ${widget.farm['size']}',
//                         style: TextStyle(fontSize: 16, color: Colors.black87),
//                         overflow: TextOverflow.ellipsis,
//                       ),
//                     ),
//                   ],
//                 ),
//                 SizedBox(height: 8),
//                 Row(
//                   children: [
//                     Icon(Icons.monetization_on, size: 16, color:Colors.black87),
//                     SizedBox(width: 5),
//                     Flexible(
//                       child: Text(
//                         'Price: ${widget.farm['price']}',
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
//                         'Land: ${widget.farm['land']}',
//                         style: TextStyle(fontSize: 16, color: Colors.black87),
//                         overflow: TextOverflow.ellipsis,
//                       ),
//                     ),
//                   ],
//                 ),
//                 SizedBox(height: 16),
//                 TextFormField(
//                   readOnly: true,
//                   decoration: InputDecoration(
//                     labelText: 'Start Date',
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     prefixIcon: Icon(Icons.calendar_today),
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
//                 SizedBox(height: 16),
//                 TextFormField(
//                   readOnly: true,
//                   decoration: InputDecoration(
//                     labelText: 'End Date',
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     prefixIcon: Icon(Icons.calendar_today),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please select end date';
//                     }
//                     return null;
//                   },
//                   onTap: () => _selectDate(context, 'end'),
//                   controller: TextEditingController(text: endDate),
//                 ),
//                 SizedBox(height: 16),
//                 TextFormField(
//                   decoration: InputDecoration(
//                     labelText: 'Total Amount',
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     prefixIcon: Icon(Icons.monetization_on),
//                   ),
//                   validator: (value) {
//                     if (value == null || value.isEmpty) {
//                       return 'Please enter total amount';
//                     }
//                     return null;
//                   },
//                   onSaved: (value) {
//                     totalAmount = value ?? '';
//                   },
//                 ),
//                 SizedBox(height: 16),
//                 DropdownButtonFormField<String>(
//                   value: paymentMethod,
//                   decoration: InputDecoration(
//                     labelText: 'Payment Method',
//                     focusedBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     enabledBorder: OutlineInputBorder(
//                       borderSide: BorderSide(color: Colors.teal, width: 2.0),
//                     ),
//                     prefixIcon: Icon(Icons.payment),
//                   ),
//                   items: ['Credit Card', 'PayPal', 'Bank Transfer']
//                       .map((method) => DropdownMenuItem(
//                     value: method,
//                     child: Text(method),
//                   ))
//                       .toList(),
//                   onChanged: (value) {
//                     setState(() {
//                       paymentMethod = value!;
//                     });
//                   },
//                 ),
//                 SizedBox(height: 16),
//                 _buildPaymentMethodFields(),
//                 SizedBox(height: 16),
//                 Center(
//                   child: ElevatedButton(
//                     onPressed: () {
//                       if (_formKey.currentState!.validate()) {
//                         _formKey.currentState!.save();
//                         _placeOrder();
//                       }
//                     },
//                     child: Text(
//                       'Request Order',
//                       style: TextStyle(color: Colors.white), // Set text color to white
//                     ),
//                     style: ElevatedButton.styleFrom(
//                       backgroundColor: Colors.teal,
//                       padding: EdgeInsets.symmetric(horizontal: 48, vertical: 12), // Increased horizontal padding
//                       textStyle: TextStyle(fontSize: 16),
//                       minimumSize: Size(double.infinity, 0), // Full width button
//                     ),
//                   ),
//                 ),
//
//               ],
//             ),
//           ),
//         ),
//       ),
//     );
//   }
// }
//
