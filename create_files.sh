for i in $(seq 1 100);
do
  echo -n "This is file " > file$i;
  echo $i >> file$i;
done
