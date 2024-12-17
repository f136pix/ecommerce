FROM node:20.16.0

WORKDIR /app

COPY package.json yarn.lock ./

RUN yarn install

COPY . .

RUN yarn build

RUN yarn global add serve

EXPOSE 5000

CMD ["serve", "-s", "dist"]