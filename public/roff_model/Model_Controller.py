#!/usr/bin/env python
# coding: utf-8

# Import
import numpy as np
import pandas as pd
from sklearn.model_selection import train_test_split
import tensorflow as tf
from tensorflow import keras

# Read CSV
# tf.get_logger().setLevel('INFO')
df = pd.read_csv('roff_model/pred_features.csv')
model = tf.keras.models.load_model('roff_model/model')
features = df.drop(['Ticker'], axis = 1)
# Generate Predictions
predictions = model.predict(features)
result = df[['Ticker', 'Adj_Close']]
result['1_Year_Price'] = predictions
result['1_Year_Price'] = result['1_Year_Price'].astype(float).round(2)
# with open('predictions.csv','a') as fd:
#   fd.write(result)
print(result)

