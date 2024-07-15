import 'dart:async';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart'; // For TextInputFormatter
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:image_picker/image_picker.dart';
import 'package:file_picker/file_picker.dart';
import 'dart:convert';

import '../configure/configure.dart'; // For JSON decoding

class AddFarmPage extends StatefulWidget {
  final int userId;

  const AddFarmPage({Key? key, required this.userId}) : super(key: key);

  @override
  _AddFarmPageState createState() => _AddFarmPageState();
}

class _AddFarmPageState extends State<AddFarmPage> {
  TextEditingController sizeController = TextEditingController();
  TextEditingController descriptionController = TextEditingController();
  TextEditingController priceController = TextEditingController();

  List<File> images = [];
  List<File> documents = [];
  bool isLoading = false;

  // Function to show toast message
  void _showToastMessage(String message, [bool isSuccess = false]) {
    Fluttertoast.showToast(
      msg: message,
      toastLength: Toast.LENGTH_SHORT,
      gravity: ToastGravity.BOTTOM,
      backgroundColor: isSuccess ? Colors.green : Colors.red,
      textColor: Colors.white,
    );
  }

  // Function to submit farm details
  Future<void> _submitFarmDetails() async {
    if (isLoading) return; // If already loading, do nothing
    setState(() {
      isLoading = true;
    });

    try {
      if (sizeController.text.isEmpty ||
          descriptionController.text.isEmpty ||
          priceController.text.isEmpty) {
        // Show toast message for each required field that is empty
        if (sizeController.text.isEmpty) {
          _showToastMessage('Size is required');
        }
        if (descriptionController.text.isEmpty) {
          _showToastMessage('Description is required');
        }
        if (priceController.text.isEmpty) {
          _showToastMessage('Price is required');
        }
      } else if (images.isEmpty) {
        // Show toast message if no images are added
        _showToastMessage('At least one image is required');
      } else if (documents.isEmpty) {
        // Show toast message if no documents are added
        _showToastMessage('At least one document is required');
      } else {
        // Check document formats
        bool allDocumentsArePDF = documents.every(
                (document) => document.path.toLowerCase().endsWith('.pdf'));
        if (!allDocumentsArePDF) {
          // Show toast message if any document is not a PDF
          _showToastMessage('All documents must be in PDF format');
        } else {
          // All required fields are filled and documents are in PDF format, proceed with submission
          final success = await _submitForm();
          // Display message based on response from the server
          _showToastMessage(success['message'], success['success']);
        }
      }
    } finally {
      setState(() {
        isLoading = false;
      });
    }
  }

  // Function to submit form data
  Future<Map<String, dynamic>> _submitForm() async {
    try {
      const url = '${Config.baseUrl}/APIs/postfarm.php'; // Replace with your PHP script URL
      var request = http.MultipartRequest('POST', Uri.parse(url));
      // Add text fields
      request.fields['user_id'] = widget.userId.toString(); // Use stored user_id
      request.fields['size'] = sizeController.text;
      request.fields['description'] = descriptionController.text;
      request.fields['price'] = priceController.text;

      // Add documents
      for (var documentFile in documents) {
        request.files.add(await http.MultipartFile.fromPath(
            'document', documentFile.path));
      }

      // Add images
      for (var imageFile in images) {
        request.files.add(await http.MultipartFile.fromPath(
            'farm_image', imageFile.path));
      }

      // Send request
      var response = await request.send();
      var responseData = await http.Response.fromStream(response);

      // Decode response
      var responseJson = json.decode(responseData.body);
      return responseJson;
    } catch (e) {
      // Error occurred
      return {
        'success': false,
        'message': 'An error occurred: $e',
      };
    }
  }

  // Function to pick image from gallery
  Future<void> pickImage() async {
    final pickedFile =
    await ImagePicker().pickImage(source: ImageSource.gallery);
    if (pickedFile != null) {
      setState(() {
        images.clear(); // Clear the existing images list
        images.add(File(pickedFile.path));
      });
    }
  }

  // Function to pick document from gallery
  Future<void> pickDocument() async {
    FilePickerResult? result = await FilePicker.platform.pickFiles(
      type: FileType.custom,
      allowedExtensions: ['pdf'],
    );

    if (result != null) {
      setState(() {
        documents.clear(); // Clear the existing documents list
        documents.add(File(result.files.single.path!));
      });
    }
  }

  // Function to remove selected image
  void removeImage(int index) {
    setState(() {
      images.removeAt(index);
    });
  }

  // Function to remove selected document
  void removeDocument(int index) {
    setState(() {
      documents.removeAt(index);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        title: Text(
          'Add Farm Details',
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
        child: Padding(
          padding: EdgeInsets.all(20.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Size
              SizedBox(height: 20.0),
              TextFormField(
                controller: sizeController,
                decoration: InputDecoration(
                  labelText: 'Hectares',
                  prefixIcon: Icon(Icons.aspect_ratio),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when not focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                ),
                keyboardType: TextInputType.number,
                inputFormatters: <TextInputFormatter>[
                  FilteringTextInputFormatter.digitsOnly
                ],
              ),
              SizedBox(height: 20.0),

              // Description
              TextFormField(
                controller: descriptionController,
                decoration: InputDecoration(
                  labelText: 'Description',
                  prefixIcon: Icon(Icons.description),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when not focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                ),
                maxLines: 3,
              ),

              SizedBox(height: 20.0),

              // Price
              TextFormField(
                controller: priceController,
                decoration: InputDecoration(
                  labelText: 'Price',
                  prefixIcon: Icon(Icons.attach_money),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when not focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                    borderSide: BorderSide(
                      color: Colors.teal, // Teal color when focused
                      width: 2.0, // Thickness of the border
                    ),
                  ),
                ),
                keyboardType: TextInputType.number,
                inputFormatters: <TextInputFormatter>[
                  FilteringTextInputFormatter.digitsOnly
                ],
              ),

              SizedBox(height: 20.0),

              ElevatedButton.icon(
                onPressed: pickImage,
                icon: Icon(Icons.image, color: Colors.white),
                label: Text(
                  'Add Images',
                  style: TextStyle(color: Colors.white),
                ),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.teal,
                  minimumSize: Size(double.infinity, 70), // Set the minimum width and height
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                ),
              ),
              SizedBox(height: 10.0),
              images.isEmpty
                  ? SizedBox.shrink()
                  : Container(
                height: 300.0,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: images.length,
                  itemBuilder: (context, index) {
                    return Stack(
                      children: [
                        Container(
                          margin: EdgeInsets.only(right: 10.0),
                          width: 348.0,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(10.0),
                            image: DecorationImage(
                              image: FileImage(images[index]),
                              fit: BoxFit.cover,
                            ),
                          ),
                        ),
                        Positioned(
                          top: 5,
                          right: 5,
                          child: GestureDetector(
                            onTap: () => removeImage(index),
                            child: CircleAvatar(
                              radius: 12.0,
                              backgroundColor: Colors.red,
                              child: Icon(
                                Icons.close,
                                color: Colors.white,
                                size: 16.0,
                              ),
                            ),
                          ),
                        ),
                      ],
                    );
                  },
                ),
              ),
              SizedBox(height: 20.0),
              ElevatedButton.icon(
                onPressed: pickDocument,
                icon: Icon(Icons.attach_file, color: Colors.white),
                label: Text(
                  'Add Documents',
                  style: TextStyle(color: Colors.white),
                ),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.teal,
                  minimumSize: Size(double.infinity, 70), // Set the minimum width and height
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                ),
              ),
              SizedBox(height: 10.0),
              documents.isEmpty
                  ? SizedBox.shrink()
                  : ListView.builder(
                shrinkWrap: true,
                itemCount: documents.length,
                itemBuilder: (context, index) {
                  return ListTile(
                    title: Text(documents[index].path.split('/').last),
                    trailing: GestureDetector(
                      onTap: () => removeDocument(index),
                      child: Icon(Icons.delete),
                    ),
                  );
                },
              ),
              SizedBox(height: 30.0),
              ElevatedButton(
                onPressed: _submitFarmDetails,
                child: Text(
                  'Submit',
                  style: TextStyle(color: Colors.white),
                ),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.teal,
                  minimumSize: Size(double.infinity, 55), // Set the minimum width and height
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(20.0),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

void main() {
  runApp(MaterialApp(
    title: 'Farm App',
    home: AddFarmPage(userId: 1), // Provide the userId here
  ));
}
