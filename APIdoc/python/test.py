import requests

r = requests.get('http://www.swingstats.com/golfers/data?id=1')

print(r.json())