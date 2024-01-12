# pip install pymysql
# pip install Flask-Cors
# ---------------------------------------------------------------------------------------------------------
from flask import Flask, jsonify, request, make_response
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
# ---------------------------------------------------------------------------------------------------------
app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+pymysql://root:@localhost/pythontest'
db = SQLAlchemy(app)
# ---------------------------------------------------------------------------------------------------------
class Product(db.Model):

   id = db.Column(db.String(20), primary_key=True)
   name = db.Column(db.String(100), nullable=False)
   price = db.Column(db.Float, nullable=False)
   type = db.Column(db.JSON)

   def to_json(self):
      return {
         'id': self.id,
         'name': self.name,
         'price': self.price,
         'type': self.type
         }
# ---------------------------------------------------------------------------------------------------------
#with app.app_context():
   #db.create_all()
# ---------------------------------------------------------------------------------------------------------
#product = Product(
   #id = 'PD-291-2306',
   #name = 'Hazard Furniture',
   #price = 12.99,
   #type = { "name": "Book", "property": "Weight", "unit": "KG", "value": "1.25" }
   #type = { "name": "DVD-disc", "property": "Size", "unit": "MB", "value": "2.25" }
   #type = { "name": "Furniture", "property": "Dimensions", "unit": "H-W-L", "value": "1-2-3" }
#)
#db.session.add(product)
#db.session.commit()
# ---------------------------------------------------------------------------------------------------------
@app.route('/api/products', methods=['GET'])
def get_products():
   products = Product.query.all()
   return jsonify([product.to_json() for product in products])
# ---------------------------------------------------------------------------------------------------------
@app.route('/api/addProduct', methods=['POST'])
def add_product():
   id_arr = ()
   p = request.json()
   for product in p:

      if (product.type.name == 'Book'):
         if (product.type.value >= 0):
            product = Product( id = product.id, name = product.name, price = product.price,
                              type = { "name": "Book", "property": "Weight", "unit": "KG", "value": product.type.value })
         else:
            response = make_response( jsonify( {"target": "value", "message": "Invalid input"}))
            return response
      
      elif (product.type.name == 'DVD-disc'):
         if (product.type.value >= 0):
            product = Product( id = product.id, name = product.name, price = product.price,
                              type = { "name": "DVD-disc", "property": "Size", "unit": "MB", "value": product.type.value })
         else:
            response = make_response(jsonify({"target": "value", "message": "Invalid input"}))
            return response
      
      elif (product.type.name == 'Furniture'):
         if (product.type.value >= 0):
            product = Product( id = product.id, name = product.name, price = product.price,
                              type = { "name": "Furniture", "property": "Dimensions", "unit": "HxWxL", "value": product.type.value })
         else:
            response = make_response(jsonify({"target": "value", "message": "Invalid input"}))
            return response
      else:
         response = make_response(jsonify({"target": "type name", "message": "Invalid input"}))
         return response

      if (product.price >= 0):
         id_arr.append(product.id)
         product = Product( id = product.id, name = product.name, price = product.price, type = product.type)
         with app.app_context():
            db.session.add(product)
            db.session.commit()
      else:
         response = make_response(jsonify({"target": "price", "message": "Invalid input"}))
         return response
   
         
   return jsonify(id_arr)
# ---------------------------------------------------------------------------------------------------------
@app.route('/api/removeProducts', methods=['POST'])
def delete_products():
   i = request.json()
   for id in i:
      product = Product.query.get(id)
      with app.app_context():
         db.session.delete(product)
         db.session.commit()
   return "Success", 201
# ---------------------------------------------------------------------------------------------------------
if __name__ == "__main__":
   app.run(debug=True)