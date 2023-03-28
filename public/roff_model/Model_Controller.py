#!/usr/bin/env python
# coding: utf-8

# Import
import numpy as np
import pandas as pd
# from sklearn.model_selection import train_test_split
import tensorflow as tf
from tensorflow import keras

# Read CSV
df = pd.read_csv('roff_model/csvs/pred_features.csv',names=[
    "EBITDA", 
    "Gross_Profit_Margin", 
    "Operating_Margin", 
    "Net_Profit_Margin", 
    "Return_on_Assets", 
    "Free_Cash_Flow_to_Net_Income", 
    "Earnings_Per_Share_Diluted", 
    "Return_On_Invested_Capital", "Adj_Close"
])
model = tf.keras.models.load_model('roff_model/roff_model')
# features = df.drop(['Ticker'], axis = 1)
# print(model.summary())
# Generate Predictions
prediction = model.predict(df, verbose=0)
# result = df[['Ticker', 'Adj_Close']]
# result['1_Year_Price'] = predictions
# result['1_Year_Price'] = result['1_Year_Price'].astype(float).round(2)
# # # with open('predictions.csv','a') as fd:
# # #   fd.write(result)
print(prediction[0][0])

