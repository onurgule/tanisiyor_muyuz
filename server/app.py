from flask import (
    Flask,
    render_template,
	request,
	redirect,
	Response,
	stream_with_context,
	send_from_directory,
	send_file
)
import requests
import random
import string
from subprocess import Popen, PIPE
import json
import datetime
import importlib
import os
import sys
import face_recognition
import pickle
from PIL import Image
import PIL

basedir = os.path.abspath(os.path.dirname(__file__))
def randomStringDigits(stringLength=6):
    """Generate a random string of letters and digits """
    lettersAndDigits = string.ascii_letters + string.digits
    return ''.join(random.choice(lettersAndDigits) for i in range(stringLength))
# Create the application instance
app = Flask(__name__, template_folder="templates")
@app.route('/')
def home():
	return "<h1>Yapay Zeka Projesi</h1><p><ul><li>G171210021 - Onur Osman Güle</li><li>G171210375 - Fatih Enis Kaya</li></ul></p>"
	
@app.route('/faceUp', methods=['GET','POST'])
def giybetimg():
	if request.files:
		file = request.files['fileToUpload']
		relations = []
		filename = file.filename
		file.save(os.path.join(basedir, "/home/YapayZeka/imgs/", filename))
		image = face_recognition.load_image_file(os.path.join(basedir, "/home/YapayZeka/imgs/", filename))
		all_face_encodings = {}
		try:
			all_face_encodings["test"] = face_recognition.face_encodings(image)[0]
			
			face_locations = face_recognition.face_locations(image)
			i=0
			rimage = Image.open(os.path.join(basedir, "/home/YapayZeka/imgs/", filename))
			print (face_locations)
			olasiPid = ""
			headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'}
			width,height = rimage.size
			for faces in face_locations:
				top = faces[3]
				left = faces[0]
				right = faces[2]
				bottom = faces[1]
				box = (top,left,bottom,right)
				crop = rimage.crop(box)
				crop.save("/home/YapayZeka/unknown/"+str(i)+"__"+filename)
				#baska kisilerle karsilastir.
				p = Popen(["face_recognition", "./faces", "/home/YapayZeka/unknown/"+str(i)+"__"+filename], stdin=PIPE, stdout=PIPE, stderr=PIPE)
				output, err = p.communicate(b"input data that is passed to subprocess' stdin")
				rc = p.returncode
				#output'un her satırını virgüle göre ayır, 2. tarafı al. ikinci tarafın altcizgisine göre ayır, sol tarafı PID. eğer hiç yoksa yeni oluştur request ile faces'e gönderip adını değiştir, PID_filename yap.
				for line in output.splitlines():
					islec = line.decode().split(',')
					olasiPidFile = islec[-1]
					olasiPid = olasiPidFile.split('__')[0]
				if olasiPid.isnumeric():
					#bulunmuş, bunun ismini değiştir. PID_filename yap. her şey facede çalışsın.
					os.rename(r"/home/YapayZeka/unknown/"+str(i)+"__"+filename,r"/home/YapayZeka/faces/"+str(olasiPid)+"__"+filename)
					relations.append([olasiPid,right,left])
					url = 'http://onurgule.com.tr/yapayzeka/api/addFace.php?pid='+olasiPid+'&face='+"/home/YapayZeka/faces/"+str(olasiPid)+"__"+filename+'&source='+os.path.join(basedir, "/home/YapayZeka/imgs/", filename)
					result = requests.get(url, headers=headers)
				else:
					#bulunmamış, yeni pid iste. ismini PID_filename yap.
					url = 'http://onurgule.com.tr/yapayzeka/api/addPerson.php?name=unnamed'
					result = requests.get(url, headers=headers)
					
					yeniPid = result.content.decode()
					os.rename(r"/home/YapayZeka/unknown/"+str(i)+"__"+filename,r"/home/YapayZeka/faces/"+str(yeniPid)+"__"+filename)
					relations.append([yeniPid,right,left])
					url = 'http://onurgule.com.tr/yapayzeka/api/addFace.php?pid='+yeniPid+'&face='+"/home/YapayZeka/faces/"+str(yeniPid)+"__"+filename+'&source='+os.path.join(basedir, "/home/YapayZeka/imgs/", filename)
					result = requests.get(url, headers=headers)
					
			#burada işle dosyayı. aldık zaten.
			for fpid in relations:
				for spid in relations:
					if spid != fpid:
						dtop = abs(spid[1]-fpid[1])
						dleft = abs(spid[2]-fpid[2])
						url = 'http://onurgule.com.tr/yapayzeka/api/addRelation.php?fpid='+str(fpid[0])+'&spid='+str(spid[0])+'&source='+os.path.join(basedir, "/home/YapayZeka/imgs/", filename)+'&top='+str(dtop)+'&left='+str(dleft)+'&height='+str(height)+'&width='+str(width)
						result = requests.get(url, headers=headers)
			return redirect("http://onurgule.com.tr/yapayzeka/train.php?err=0"
			, code=302)
		except:
			return redirect("http://onurgule.com.tr/yapayzeka/train.php?err=1", code=302)
		else:
			return redirect("http://onurgule.com.tr/yapayzeka/train.php", code=302)

@app.route('/getPhoto', methods=["POST","GET"])
def getPhoto():
	path = str(request.args.get('path'))
	
	return send_file(path, mimetype='image/gif')
	
@app.route('/personMerge', methods=["POST","GET"])
def personMerge():
	fpid = str(request.args.get('fpid'))
	spid = str(request.args.get('spid'))
	path = "/home/YapayZeka/faces/"
	dirs = os.listdir(path)
	for file in dirs:
		olasiPid = file.split('__')[0]
		if olasiPid.isnumeric():
			#fpidleri spid yap.
			if olasiPid == fpid:
				os.rename(r"/home/YapayZeka/faces/"+file,r"/home/YapayZeka/faces/"+spid+"__"+file.split('__')[1])
	
	return "ok"
if __name__ == '__main__':
    app.run(host='0.0.0.0',port=800,debug=True)
