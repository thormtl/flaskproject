from flask import Flask, flash, redirect, render_template, request, session, abort
import plotly

import pandas as pd
import numpy as np

app = Flask(__name__)


@app.route("/")
def index():
    return render_template(
        'stockpage.html')


# @app.route("/hello/<string:name>/")
# def hello(name):
#     return render_template(
#         'test.html', name=name)


if __name__ == "__main__":
    app.run()