find pub/media/catalog/product/ -type f -name "*.jpg" -exec basename {} \; | while read -r filename; do     grep -q "$filename" tmp/*.sql && echo -n "." || (echo "$filename not found in tmp/db.sql"); done

# find pub/media/catalog/product/ -type f -name "*.jpg" -exec basename {} \; | while read -r filename; do     grep -q "$filename" tmp/*.sql && echo -n "." || (echo "$filename not found in tmp/db.sql"; find pub/media/catalog/product/ -type f -name "$filename" -exec mv {} tmp/media/ \;); done

# nohup bash -c '
# find pub/media/catalog/product/ -type f -name "*.jpg" -exec basename {} \; | while read -r filename; do
#    grep -q "$filename" tmp/*.sql && echo -n "." || (echo "$filename not found in tmp/db.sql"; find pub/media/catalog/product/ -type f -name "$filename" -exec mv {} tmp/media/ \;);
#done
#' > output.log 2>&1 &
