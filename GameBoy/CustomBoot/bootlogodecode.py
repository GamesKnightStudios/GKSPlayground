from itertools import chain
from PIL import Image

bytes_raw = bytes.fromhex(
    'ce ed 66 66 cc 0d 00 0b 03 73 00 83' \
    '00 0c 00 0d 00 08 11 1f 88 89 00 0e' \
    'dc cc 6e e6 dd dd d9 99 bb bb 67 63' \
    '6e 0e ec cc dd dc 99 9f bb b9 33 3e'
    )

# Split bytes into separate bytes for upper and lower nibbles
logo_nibs = b''.join(
    bytes([b >> 4, b & 15]) for b in bytes_raw
    )

# The mapping can be generated as a chain of ranges
mapping = chain.from_iterable(
        range(x+y, 48+y, 4) for y in (0, 48) for x in range(4)
    )

# Sort the nibbles according to the mapping
sorted_nibs = [logo_nibs[x] for x in mapping]

# Recombine the nibbles into a 48-byte string
logo_out = bytes(
    (sorted_nibs[n] << 4) | sorted_nibs[n+1] for n in range(0, 96, 2)
    )

Image.frombytes('1', (48, 8), logo_out).save('logo.bmp')
