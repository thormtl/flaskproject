from flask import Flask, flash, redirect, render_template, request, session, abort
import plotly
import plotly.graph_objs as go
import plotly.plotly as py

import json
import pandas as pd
import numpy as np
import os
from settings import APP_STATIC

app = Flask(__name__)
app.debug = True


@app.route("/")
def index():
    col_names = names=["date","kurs","plus_minus","bud","udbud"]
    # df = pd.read_csv(os.path.join(APP_STATIC, 'stocks/vestas.csv'), names=col_names )
    df = pd.read_csv("/home/dktholar/stockData/vestas.csv", names=col_names ).query("kurs > 5.0")

    # rng = pd.date_range('1/1/2011', periods=7500, freq='H')
    # ts = pd.Series(np.random.randn(len(rng)), index=rng)

    # graphs = [
    #     dict(
    #         data=[
    #             dict(
    #                 x=df['date'],  # Can use the pandas data structures directly
    #                 y=df['kurs']
    #             )
    #         ]
    #     )
    # ]

    graphs = dict(
        data=[go.Scatter(
                x=df['date'],
                y=df['kurs']
        )],
        layout=dict(
            title="Vestas A/S",
            yaxis=dict(
                title='DKK'
            ),
            xaxis=dict(
                title='Date'
            )
        )
    )


    # Add "ids" to each of the graphs to pass up to the client
    # for templating
    # ids = ['VESTAS-{}'.format(i) for i, _ in enumerate(graphs)]
    ids = ['VESTAS A/S']

    # Convert the figures to JSON
    # PlotlyJSONEncoder appropriately converts pandas, datetime, etc
    # objects to their JSON equivalents

    graphJSON = json.dumps(graphs, cls=plotly.utils.PlotlyJSONEncoder)

    return render_template(
        'stockpage.html',
        ids=ids,
        graphJSON=graphJSON
    )


# @app.route("/hello/<string:name>/")
# def hello(name):
#     return render_template(
#         'test.html', name=name)


if __name__ == "__main__":


    app.run(host='0.0.0.0')
    # app.run()
