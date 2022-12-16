/*
*
*
*
AUTHOR       : Kanish Ravikumar
VERSION      : 001
RELEASE DATE : 16-12-2022
*
*
*
*/

var Crypto = require('crypto')
const fs = require('fs')

var key = "e94eb5119f81cc772799494b12ea5f03";
var iv = "8c9e020cdbfa4803";
var cipher = "AES-256-CBC"


function Encryptor(string, method, ekey, eiv) {
  var encrypt = Crypto.createCipheriv(method, ekey, eiv);
  var aes_encrypted = encrypt.update(string, 'utf8', 'base64') + encrypt.final('base64')
  return Buffer.from(aes_encrypted).toString('base64')
}

function Decryptor(encstring, dmethod, dkey, div) {
  var buff = Buffer.from(encstring, 'base64');
  encstring = buff.toString('utf-8')
  var decryptor = Crypto.createDecipheriv(dmethod, dkey, div);
  return decryptor.update(encstring, 'base64', 'utf8') + decryptor.final('utf8')
}

function jsonConcat(o1, o2) {
  for (var key in o2) {
    o1[key] = o2[key];
  }
  return o1;
}

class Jsdb {
  add_row(fileloc, jsdb_code) {
    this.fileloc = fileloc+".jsdb";
    this.jsdb_code = jsdb_code.replaceAll("`", '"');
    this.file_full = fs.readFileSync(this.fileloc).toString('utf-8');
    this.jsons = new Array();
    if (this.file_full != "") {
      this.data = Decryptor(this.file_full, cipher, key, iv);
      this.jsons = JSON.parse("[" + this.data + "]");
      this.jsons.push(this.jd)
      this.jsons = this.jsons.filter(function(x) {
        return x !== null
      });
    }
    this.jsons.push(JSON.parse(this.jsdb_code))
    this.jsons = this.jsons.filter(function(x) {
      return x !== null
    });
    this.fnd = JSON.stringify(this.jsons.filter(function(x) {
      return x !== null
    }))
    this.enc = Encryptor(this.fnd.slice(1, -1), cipher, key, iv);
    fs.writeFileSync(this.fileloc, this.enc)
  }
  get(fileloc) {
    this.fileloc = fileloc+".jsdb";
    this.file_full = fs.readFileSync(this.fileloc).toString('utf-8');
    this.jsons = new Array();
    if (this.file_full != "") {
      this.data = Decryptor(this.file_full, cipher, key, iv);
      this.jsons = JSON.parse("[" + this.data + "]");
      this.jsons = this.jsons.filter(function(x) {
        return x !== null
      });
      return this.jsons;
    } else {
      console.error("Database '" + this.fileloc + "' is empty")
    }
  }
  get_row(fileloc, jsdb_code) {
    this.fileloc = fileloc+".jsdb";
    this.file_full = fs.readFileSync(this.fileloc).toString('utf-8');
    this.jsons = new Array();
    if (this.file_full != "") {
      this.jsdb_code = jsdb_code.replaceAll("`", '"');
      this.data = Decryptor(this.file_full, cipher, key, iv);
      this.jsons = JSON.parse("[" + this.data + "]");
      this.jsons = this.jsons.filter(function(x) {
        return x !== null
      });
      this.obj = JSON.parse(this.jsdb_code)
      var obj = this.obj
      var jsons = this.jsons
      Object.keys(this.obj).forEach(function(k, v) {
        jsons = jsons.filter(function(x) {
          return x[k] === obj[k]
        });

      });
      this.jsons = jsons;
      return this.jsons;
    } else {
      console.error("Database '" + this.fileloc + "' is empty")
    }
  }

  update_row(fileloc, jsdb_code, update_code) {
    this.fileloc = fileloc+".jsdb";
    this.update_code = update_code.replaceAll("`", '"');
    this.file_full = fs.readFileSync(this.fileloc).toString('utf-8');
    this.jsons = new Array();
    if (this.file_full != "") {
      this.jsdb_code = jsdb_code.replaceAll("`", '"');
      this.data = Decryptor(this.file_full, cipher, key, iv);
      this.jsons = JSON.parse("[" + this.data + "]");
      this.jsons = this.jsons.filter(function(x) {
        return x !== null
      });
      var njs = this.jsons;
      this.obj = JSON.parse(this.jsdb_code)
      var obj = this.obj
      var jsons = this.jsons
      Object.keys(this.obj).forEach(function(k, v) {
        jsons = jsons.filter(function(x) {
          return x[k] === obj[k]
        });

      });
      this.jsons = jsons;
      this.neuobj = JSON.parse(this.update_code)
      var neuobj = this.neuobj
      var charr = new Array()
      var old = JSON.stringify(njs);
      Object.keys(njs).forEach(function(k, v) {
        for (var row in jsons) {
          if (njs[k] == jsons[row]) {
            var mx = jsonConcat(jsons[row], neuobj)
          }
        }
        charr.push(njs[k])

      });
      this.jsons = charr

      this.fnd = JSON.stringify(this.jsons)
      this.enc = Encryptor(this.fnd.slice(1, -1), cipher, key, iv);
      fs.writeFileSync(this.fileloc, this.enc)

    } else {
      console.error("Database '" + this.fileloc + "' is empty")
    }
  }

  remove_row(fileloc, jsdb_code) {
    this.fileloc = fileloc+".jsdb";
    this.file_full = fs.readFileSync(this.fileloc).toString('utf-8');
    this.jsons = new Array();
    if (this.file_full != "") {
      this.jsdb_code = jsdb_code.replaceAll("`", '"');
      this.data = Decryptor(this.file_full, cipher, key, iv);
      this.jsons = JSON.parse("[" + this.data + "]");
      this.jsons = this.jsons.filter(function(x) {
        return x !== null
      });
      var njs = this.jsons;
      this.obj = JSON.parse(this.jsdb_code)
      var obj = this.obj
      var jsons = this.jsons
      Object.keys(this.obj).forEach(function(k, v) {
        jsons = jsons.filter(function(x) {
          return x[k] === obj[k]
        });

      });
      this.jsons = jsons;
      var charr = new Array()
      charr = njs;
      var old = JSON.stringify(njs);
      Object.keys(njs).forEach(function(k, v) {
        for (var row in jsons) {
          if (njs[k] == jsons[row]) {
            var index = charr.indexOf(njs[k])
            if (index > -1) {
              charr.splice(index, 1);
            }
          }
        }


      });
      this.jsons = charr
      this.fnd = JSON.stringify(this.jsons)
      this.enc = Encryptor(this.fnd.slice(1, -1), cipher, key, iv);
      fs.writeFileSync(this.fileloc, this.enc)

    } else {
      console.error("Database '" + this.fileloc + "' is empty")
    }
  }

  safe(stringToPerf) {
    this.stp = stringToPerf;
    this.stp = this.stp.replaceAll("`", "'")
    this.stp = this.stp.replaceAll("<", "&lt;")
    this.stp = this.stp.replaceAll(">", "&gt;")
    return this.stp
  }
  uniqstr(length = 10) {

    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;

  }

}

module.exports = Jsdb
