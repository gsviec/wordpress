### Làm website bán hàng bằng wordpress
Có khá là nhiều cách cài đặt LAMP để chạy wordpress nhưng tôi khuyên các bạn nên chạy docker, nếu bạn nào chưa hiểu docker là gì có thể xem [khóa học docker căn bản](https://gsviec.com/playlist/khoa-hoc-docker-can-ban)

```
docker-compose up -d
sudo chmod 777  -R wp-content/
git config core.fileMode false

```
